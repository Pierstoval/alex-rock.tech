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

namespace App\Form\DTO;

use App\Entity\TrainingOffer;
use Symfony\Component\Validator\Constraints as Assert;

class AdminTrainingOfferDTO implements EasyAdminDTOInterface
{
    /**
     * @Assert\NotBlank()
     */
    public ?string $title = null;

    /**
     * @Assert\NotBlank()
     */
    public ?string $description = null;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    public ?int $price = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(App\Entity\TrainingOffer::LANGUAGES)
     */
    public ?string $language = null;

    /**
     * @param TrainingOffer $entity
     */
    public static function createFromEntity(object $entity): self
    {
        $self = new self();

        $self->title = $entity->getTitle();
        $self->description = $entity->getDescription();
        $self->language = $entity->getLanguage();
        $self->price = $entity->getPrice();

        return $self;
    }

    public static function createEmpty(): self
    {
        return new self();
    }
}
