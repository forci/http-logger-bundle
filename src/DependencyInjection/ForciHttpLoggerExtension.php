<?php

namespace Forci\Bundle\HttpLoggerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ForciHttpLoggerExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container) {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $bag = $container->getParameterBag();

        $bag->set('forci_http_logger.configs', $config['configs']);

        $loader->load('services.xml');
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container) {
        return new Configuration();
    }

}