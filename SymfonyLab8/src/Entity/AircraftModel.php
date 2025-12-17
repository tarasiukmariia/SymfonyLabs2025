<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use App\Repository\AircraftModelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Action\AircraftModel\BoostRangeAction;

#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
#[ORM\Table(name: 'aircraft_models')]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),

        new Post(
            uriTemplate: '/aircraft_models/{id}/boost_range',
            controller: BoostRangeAction::class,
            denormalizationContext: ['groups' => ['model:write']],
            normalizationContext: ['groups' => ['model:read']],
            name: 'boost_range'
        )
    ],
    normalizationContext: ['groups' => ['model:read']],
    denormalizationContext: ['groups' => ['model:write']]
)]
class AircraftModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['model:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Виробник не може бути пустим")]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: "Назва виробника має містити мінімум {{ limit }} символи",
        maxMessage: "Назва виробника не може перевищувати {{ limit }} символів"
    )]
    #[Groups(['model:read', 'model:write', 'aircraft:read'])]
    private ?string $manufacturer = null;

    #[ORM\Column(length: 100)] 
    #[Assert\NotBlank(message: "Назва моделі не може бути пустою")]
    #[Assert\Length(
        max: 100,
        maxMessage: "Назва моделі не може перевищувати {{ limit }} символів"
    )]
    #[Groups(['model:read', 'model:write', 'aircraft:read'])]
    private ?string $modelName = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Максимальна дальність польоту обов'язкова")]
    #[Assert\Positive(message: "Дальність польоту має бути більше нуля")]
    #[Assert\Range(
        min: 100, 
        max: 20000, 
        notInRangeMessage: "Дальність польоту має бути в межах від {{ min }} до {{ max }} км"
    )]
    #[Groups(['model:read', 'model:write'])]
    private ?int $maxRangeKm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): static
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName): static
    {
        $this->modelName = $modelName;
        return $this;
    }

    public function getMaxRangeKm(): ?int
    {
        return $this->maxRangeKm;
    }

    public function setMaxRangeKm(int $maxRangeKm): static
    {
        $this->maxRangeKm = $maxRangeKm;
        return $this;
    }
}