<?php

namespace App\Controller;

use App\PublicService;
use MeteoConcept\HCaptchaBundle\Form\HCaptchaType;
use Psr\Http\Client\NetworkExceptionInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactController implements PublicService
{
    public function __construct(
        private readonly bool $debug,
        private readonly MailerInterface $mailer,
        private readonly FormFactoryInterface $formFactory,
        private readonly SerializerInterface $serializer,
    ) {
    }

    #[Route("/api/send-email", methods: ["POST"])]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm();

        try {
            $form->handleRequest($request);
        } catch (NetworkExceptionInterface) {
            // In case Captcha doesn't work
            return new Response('Captcha is not set up properly', 500);
        }

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException('Please submit the form.');
        }

        if (!$form->isValid()) {
            $serialized = $this->serializer->normalize($form, null, ['type' => 'errors', 'status_code' => 400]);

            return (new JsonResponse(data: $serialized, status: 400))->setEncodingOptions(128);
        }

        $data = $form->getData();

        $subject = $data['subject'];
        $email = $data['email'];
        $content = htmlspecialchars($data['content'] ?: '');

        $message = (new Email())
            ->from('contact@alex-rock.tech')
            ->replyTo($email)
            ->to('alex'.chr(64).'orbitale.io')
            ->subject('New contact')
            ->html(
                <<<HTML
                <html lang="en">
                <head>
                    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">
                     <title>New contact</title>
                </head>
                <body>
                  <p>New contact:</p>
                  <p>Subject: {$subject}</p>
                  <p>Email: {$email}</p>
                  <p>Content: {$content}</p>
                </body>
                </html>
                HTML
            )
        ;

        $this->mailer->send($message);

        return new Response();
    }

    private function createForm(): FormInterface
    {
        $builder = $this->formFactory->createNamedBuilder('', options: [
            'allow_extra_fields' => true,
            'csrf_protection' => false,
        ])
            ->add('subject', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [new Assert\NotBlank(), new Assert\Email()],
            ])
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
        ;

        if (!$this->debug) {
            $builder->add('captcha', HCaptchaType::class);
        }

        return $builder->getForm();
    }
}
