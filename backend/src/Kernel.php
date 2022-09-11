<?php

namespace App;

use App\Controller\ContactController;
use MeteoConcept\HCaptchaBundle\MeteoConceptHCaptchaBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait {
        configureRoutes as baseConfigureRoutes;
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new MeteoConceptHCaptchaBundle(),
        ];
    }

    private function configureRoutes(RoutingConfigurator $routes): void
    {
        $this->baseConfigureRoutes($routes);

        $routes
            ->add('send-email', '/send-email')
            ->controller(ContactController::class)
            ->methods(['POST'])
        ;
    }
}
