<?php

declare(strict_types=1);

/*
 * This file is part of the piers.tech package.
 *
 * (c) Alex "Pierstoval" Rock <alex@piers.tech>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use App\Form\DTO\AdminServiceDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ORM\Table(
 *     name="services",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="slug_and_language", columns={"slug", "language"})
 *     }
 * )
 */
class Service
{
    public const LANGUAGES = [
        'fr' => 'fr',
        'en' => 'en',
    ];

    public const DURATION_UNITS = [
        'duration_units.hours' => 'hours',
        'duration_units.days' => 'days',
        'duration_units.weeks' => 'weeks',
        'duration_units.months' => 'months',
    ];

    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private ?string $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private string $slug;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private string $description;

    /**
     * Stored in cents.
     * Always in cents.
     *
     * @ORM\Column(name="price", type="integer")
     */
    private int $price;

    /**
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private ?int $duration = null;

    /**
     * @ORM\Column(name="duration_unit", type="string", nullable=false)
     */
    private ?string $durationUnit = null;

    /**
     * @ORM\Column(name="language", type="string", length=255)
     */
    private string $language;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service")
     * @ORM\JoinColumn(name="previous_id", nullable=true)
     */
    private ?self $previous;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->title;
    }

    public static function fromAdmin(AdminServiceDTO $dto, string $id, callable $slugger): self
    {
        $self = new self($id);

        $self->title = $dto->title;
        $self->description = $dto->description;
        $self->language = $dto->language;
        $self->price = $dto->price;
        $self->duration = $dto->duration;
        $self->durationUnit = $dto->durationUnit;
        $self->previous = $dto->previous;

        $self->slug = $slugger($self->title.'_'.$self->language);

        return $self;
    }

    public function updateFromAdmin(AdminServiceDTO $dto): void
    {
        $this->title = $dto->title;
        $this->description = $dto->description;
        $this->language = $dto->language;
        $this->price = $dto->price;
        $this->duration = $dto->duration;
        $this->previous = $dto->previous;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }
}
