<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *         "phone_details",
 *         parameters = { "id" = "expr(object.getId())" },
 *         absolute = true
 *     )
 * )
 * @Hateoas\Relation(
 *     "catalog",
 *     href = @Hateoas\Route(
 *         "phones_catalog",
 *         absolute = true
 *     )
 * )
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Since("1.0")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $format;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $integrated_components;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $width;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $depth;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $weight;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $caseColor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $caseMaterial;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $mobileBroadbandGeneration;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $operatingSystem;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $simCardType;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $clockFrequency;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $processorCoreQty;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $architecture;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $ram;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $internalMemoryCapacity;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $userMemory;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $frontCameraResolution;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $backCameraResolution;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $batteryTechnologie;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Serializer\Since("1.0")
     */
    private $brand;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Since("1.0")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getIntegratedComponents(): ?string
    {
        return $this->integrated_components;
    }

    public function setIntegratedComponents(?string $integrated_components): self
    {
        $this->integrated_components = $integrated_components;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(?string $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getDepth(): ?string
    {
        return $this->depth;
    }

    public function setDepth(?string $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(?string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCaseColor(): ?string
    {
        return $this->caseColor;
    }

    public function setCaseColor(?string $caseColor): self
    {
        $this->caseColor = $caseColor;

        return $this;
    }

    public function getCaseMaterial(): ?string
    {
        return $this->caseMaterial;
    }

    public function setCaseMaterial(?string $caseMaterial): self
    {
        $this->caseMaterial = $caseMaterial;

        return $this;
    }

    public function getMobileBroadbandGeneration(): ?string
    {
        return $this->mobileBroadbandGeneration;
    }

    public function setMobileBroadbandGeneration(?string $mobileBroadbandGeneration): self
    {
        $this->mobileBroadbandGeneration = $mobileBroadbandGeneration;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operatingSystem;
    }

    public function setOperatingSystem(?string $operatingSystem): self
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    public function getSimCardType(): ?string
    {
        return $this->simCardType;
    }

    public function setSimCardType(?string $simCardType): self
    {
        $this->simCardType = $simCardType;

        return $this;
    }

    public function getClockFrequency(): ?string
    {
        return $this->clockFrequency;
    }

    public function setClockFrequency(?string $clockFrequency): self
    {
        $this->clockFrequency = $clockFrequency;

        return $this;
    }

    public function getProcessorCoreQty(): ?string
    {
        return $this->processorCoreQty;
    }

    public function setProcessorCoreQty(?string $processorCoreQty): self
    {
        $this->processorCoreQty = $processorCoreQty;

        return $this;
    }

    public function getArchitecture(): ?string
    {
        return $this->architecture;
    }

    public function setArchitecture(?string $architecture): self
    {
        $this->architecture = $architecture;

        return $this;
    }

    public function getRam(): ?string
    {
        return $this->ram;
    }

    public function setRam(?string $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    public function getInternalMemoryCapacity(): ?string
    {
        return $this->internalMemoryCapacity;
    }

    public function setInternalMemoryCapacity(?string $internalMemoryCapacity): self
    {
        $this->internalMemoryCapacity = $internalMemoryCapacity;

        return $this;
    }

    public function getUserMemory(): ?string
    {
        return $this->userMemory;
    }

    public function setUserMemory(?string $userMemory): self
    {
        $this->userMemory = $userMemory;

        return $this;
    }

    public function getFrontCameraResolution(): ?string
    {
        return $this->frontCameraResolution;
    }

    public function setFrontCameraResolution(?string $frontCameraResolution): self
    {
        $this->frontCameraResolution = $frontCameraResolution;

        return $this;
    }

    public function getBackCameraResolution(): ?string
    {
        return $this->backCameraResolution;
    }

    public function setBackCameraResolution(?string $backCameraResolution): self
    {
        $this->backCameraResolution = $backCameraResolution;

        return $this;
    }

    public function getBatteryTechnologie(): ?string
    {
        return $this->batteryTechnologie;
    }

    public function setBatteryTechnologie(?string $batteryTechnologie): self
    {
        $this->batteryTechnologie = $batteryTechnologie;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
