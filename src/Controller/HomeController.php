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

namespace App\Controller;

use App\Form\DTO\ContactMessage;
use App\Form\Type\ContactType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController
{
    private Environment $twig;
    private FormFactoryInterface $formFactory;

    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory
    ) {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
    }

    public function __invoke(): Response
    {
        $form = $this->formFactory->create(ContactType::class, new ContactMessage());

        return new Response($this->twig->render('index.html.twig', [
            'contact_form' => $form->createView(),
        ]));
    }
}
