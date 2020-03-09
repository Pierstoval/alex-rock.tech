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

namespace App\Admin;

use App\Entity\TrainingOffer;
use App\Form\DTO\AdminTrainingOfferDTO;
use App\Form\DTO\EasyAdminDTOInterface;
use Closure;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminTrainingOfferController extends EasyAdminController
{
    use BaseDTOControllerTrait;

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    protected function getDTOClass(): string
    {
        return AdminTrainingOfferDTO::class;
    }

    /**
     * @param AdminTrainingOfferDTO $dto
     */
    protected function createEntityFromDTO(EasyAdminDTOInterface $dto): object
    {
        $slugger = $this->getSluggerCallback();

        return TrainingOffer::fromAdmin($dto, \uuid_create(\UUID_TYPE_RANDOM), $slugger);
    }

    /**
     * @param TrainingOffer         $entity
     * @param AdminTrainingOfferDTO $dto
     */
    protected function updateEntityWithDTO(object $entity, EasyAdminDTOInterface $dto): object
    {
        return $this->doUpdateEntityWithDTO($entity, $dto);
    }

    private function doUpdateEntityWithDTO(TrainingOffer $entity, AdminTrainingOfferDTO $dto): TrainingOffer
    {
        $entity->updateFromAdmin($dto);

        return $entity;
    }

    private function getSluggerCallback(): Closure
    {
        $slugger = $this->slugger;

        return static function (string $name) use ($slugger) {
            return $slugger->slug($name)->toString();
        };
    }
}
