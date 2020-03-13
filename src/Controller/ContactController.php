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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class ContactController
{
    private Environment $twig;
    private FormFactoryInterface $formFactory;
    private MailerInterface $mailer;
    private UrlGeneratorInterface $router;

    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        MailerInterface $mailer,
        UrlGeneratorInterface $router
    ) {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function __invoke(Request $request, Session $session): Response
    {
        $contactMessage = new ContactMessage();

        $form = $this->formFactory->create(ContactType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sendContactEmail($contactMessage);

            $session->getFlashBag()->add('success', 'contact.success');

            return new RedirectResponse($this->router->generate('home'));
        }

        return new Response($this->twig->render('contact.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    private function sendContactEmail(ContactMessage $contactMessage): void
    {
        $mail = (new TemplatedEmail())
            ->from($contactMessage->email)
            ->to('alex.ancelet+alex-rock.tech@gmail.com')
            ->subject($contactMessage->subject)
            ->htmlTemplate('email/contact.html.twig')
            ->textTemplate('email/contact.txt.twig')
            ->context([
                'contact_message' => $contactMessage,
            ])
        ;

        $this->mailer->send($mail);
    }
}
