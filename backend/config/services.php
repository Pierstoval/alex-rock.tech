<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Controller\ContactController;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

return static function (ContainerConfigurator $container) {
    $container->extension('framework', [
        'secret' => '%env(APP_SECRET)%',
        'http_method_override' => false,
        'session' => [
            'handler_id' => null,
            'cookie_secure' => 'auto',
            'cookie_samesite' => 'lax',
            'storage_factory_id' => 'session.storage.factory.native',
        ],
        'php_errors' => [
            'log' => true,
        ],
        'mailer' => [
            'enabled' => true,
            'dsn' => '%env(MAILER_DSN)%',
        ],
        'router' => [
            'utf8' => true,
            'strict_requirements' => null,
        ]
    ]);

    $container->parameters()
        ->set('hcaptcha_site_key', '%env(resolve:HCAPTCHA_SITE_KEY)%')
        ->set('hcaptcha_secret', '%env(resolve:HCAPTCHA_SECRET)%')
    ;

    $container->extension('meteo_concept_h_captcha', [
        'hcaptcha' => [
            'site_key' => '%hcaptcha_site_key%',
            'secret' => '%hcaptcha_secret%',
        ],
        'validation' => 'strict',
    ]);

    $container->services()
        ->set(ContactController::class)->public()->autowire()->bind('bool $debug', '%kernel.debug%')
        ->set(Psr17Factory::class)
        ->alias(RequestFactoryInterface::class, Psr17Factory::class)
        ->alias(StreamFactoryInterface::class, Psr17Factory::class)
    ;
};
