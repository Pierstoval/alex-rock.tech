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

use App\Entity\Service;
use App\Form\DTO\AdminServiceDTO;
use App\Form\DTO\EasyAdminDTOInterface;
use Closure;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminServiceController extends EasyAdminController
{
    use BaseDTOControllerTrait;

    private string $uploadPath;
    private SluggerInterface $slugger;

    public function __construct(string $uploadPath, SluggerInterface $slugger)
    {
        $this->uploadPath = $uploadPath;
        $this->slugger = $slugger;
    }

    protected function getDTOClass(): string
    {
        return AdminServiceDTO::class;
    }

    /**
     * @param AdminServiceDTO $dto
     */
    protected function createEntityFromDTO(EasyAdminDTOInterface $dto): object
    {
        $slugger = $this->getSluggerCallback();

        return Service::fromAdmin($dto, \uuid_create(\UUID_TYPE_RANDOM), $slugger);
    }

    /**
     * @param Service         $entity
     * @param AdminServiceDTO $dto
     */
    protected function updateEntityWithDTO(object $entity, EasyAdminDTOInterface $dto): object
    {
        return $this->doUpdateEntityWithDTO($entity, $dto);
    }

    private function doUpdateEntityWithDTO(Service $entity, AdminServiceDTO $dto): Service
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
