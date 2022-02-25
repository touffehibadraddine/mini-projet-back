<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Api;
use App\Entity\Historique;

class GeneralController extends AbstractController
{

    public function __construct(Api $api)
    {
        $this->api=$api;
    }

    /**
     * @Route(
     *     name="get_denomination_name",
     *     path="/api/get_denomination/{sirene}",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Historique::class,
     *         "_api_item_operation_name"="get_denomination"
     *     }
     * )
     */
    public function __invoke($sirene): JsonResponse
    {
        $content= $this->api->getCompanyBySirene($sirene);

        if(!isset($content['unite_legale']['denomination']))
            return new JsonResponse($content);

        $historique = new Historique();
        $historique->setSiren($sirene);
        $historique->setDate(new \DateTime());
        $historique->setResult($content['unite_legale']['denomination']);
        $this->getDoctrine()->getManager()->persist($historique);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse([
            "id" => $historique->getId(),
            "denomination" => $content['unite_legale']['denomination']
        ]);
    }

    /**
     * @Route("/general/{sirene}", name="general")
     */
    public function index($sirene): Response
    {
        $content=$this->api->getCompanyBySirene($sirene);
        if(is_null($content))
            throw new Exception('Invalid strength passe');

        $res = json_decode($content, true);
        if(!isset($res['unite_legale']['denomination']))
            throw new Exception('Not found');
        $json = ["denomination"=>$res['unite_legale']['denomination']];

        return new JsonResponse($json);
    }
}
