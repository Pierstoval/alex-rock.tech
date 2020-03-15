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

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\Yaml\Yaml;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        $pricesFile = $container->getParameter('kernel.project_dir').'/data/trainings_prices.yaml';
        $trainingPrices = Yaml::parseFile($pricesFile);
        $trainingPrices = $trainingPrices['trainings_prices'];
        $trainingPrices = \trim($trainingPrices);
        $trainingPrices = \explode("\n", $trainingPrices);
        $trainingPrices = \array_combine(\range(1, \count($trainingPrices)), $trainingPrices);
        $trainingPrices = \array_map(function ($i) use (&$maxNumberOfDays) {
            $a = \array_map('intval', \explode(';', $i));

            if (!$maxNumberOfDays) {
                $maxNumberOfDays = \count($a);
            }

            return \array_combine(\range(1, \count($a)), \array_values($a));
        }, $trainingPrices);

        $container->setParameter('trainings_prices', $trainingPrices);
        $container->setParameter('max_number_of_students', \count($trainingPrices));
        $container->setParameter('max_number_of_days', $maxNumberOfDays);
        $container->addResource(new FileResource($pricesFile));
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', \PHP_VERSION_ID < 70400 || $this->debug);
        $container->setParameter('container.dumper.inline_factories', true);
        $confDir = $this->getProjectDir().'/config';

        $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{packages}/'.$this->environment.'/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir().'/config';

        $routes->import($confDir.'/{routes}/'.$this->environment.'/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }
}
