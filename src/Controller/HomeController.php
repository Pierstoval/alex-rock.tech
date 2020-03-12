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

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController
{
    private Environment $twig;
    private ServiceRepository $serviceRepository;

    public function __construct(Environment $twig, ServiceRepository $serviceRepository)
    {
        $this->twig = $twig;
        $this->serviceRepository = $serviceRepository;
    }

    public function __invoke(): Response
    {
        return new Response($this->twig->render('index.html.twig', [
            'services' => $this->serviceRepository->findAll(),
        ]));
    }
}
