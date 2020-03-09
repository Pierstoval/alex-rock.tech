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

use App\Form\DTO\AdminTrainingOfferDTO;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingOfferRepository")
 * @ORM\Table(
 *     name="training_offers",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="slug_and_language", columns={"slug", "language"})
 *     }
 * )
 */
class TrainingOffer
{
    public const LANGUAGES = [
        'fr' => 'fr',
        'en' => 'en',
    ];

    /**
     * @ORM\Column(type="string")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private string $id;

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
     * @ORM\Column(name="language", type="string", length=255)
     */
    private string $language;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromAdmin(AdminTrainingOfferDTO $dto, string $id, callable $slugger): self
    {
        $self = new self($id);

        $self->title = $dto->title;
        $self->description = $dto->description;
        $self->language = $dto->language;
        $self->price = $dto->price;

        $self->slug = $slugger($self->title.'_'.$self->language);

        return $self;
    }

    public function updateFromAdmin(AdminTrainingOfferDTO $dto): void
    {
        $this->title = $dto->title;
        $this->description = $dto->description;
        $this->language = $dto->language;
        $this->price = $dto->price;
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
