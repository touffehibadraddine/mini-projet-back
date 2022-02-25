<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\GeneralController;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(itemOperations={
 *     "get_denomination"={
 *         "read"=false,
 *         "method"="GET",
 *         "path"="/get_denomination/{sirene}",
 *         "controller"=GeneralController::class,
 *         "normalization_context"={"groups"={"common:read"}}
 *     }
 * })
 *
 * @ORM\Entity(repositoryClass=HistoriqueRepository::class)
 */
class Historique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("common:read")
     * @ApiProperty(iri="https://schema.org/identifier", identifier=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups("common:read")
     */
    private $siren;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $result;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
