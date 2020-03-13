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

use Symfony\Component\Validator\Constraints as Assert;

class ContactMessage
{
    /**
     * @Assert\NotBlank(message="contact.validation.contact.form.name")
     */
    public ?string $name = '';

    /**
     * @Assert\NotBlank(message="contact.validation.contact.form.email")
     * @Assert\Email(mode="strict", message="contact.validation.contact.form.email_strict")
     */
    public ?string $email = '';

    public ?string $phone = null;

    /**
     * @Assert\NotBlank(message="contact.validation.contact.form.subject")
     */
    public ?string $subject = '';

    /**
     * @Assert\NotBlank(message="contact.validation.contact.form.message")
     */
    public ?string $message = '';
}
