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

interface EasyAdminDTOInterface
{
    /**
     * @return static
     */
    public static function createFromEntity(object $entity): self;

    /**
     * @return static
     */
    public static function createEmpty(): self;
}
