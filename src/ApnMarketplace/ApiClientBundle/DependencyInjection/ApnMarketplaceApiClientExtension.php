<?php

namespace ApnMarketplace\ApiClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ApnMarketplaceApiClientExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('apnmarketplace.client_id', $config['id']);
        $container->setParameter('apnmarketplace.client_secret', $config['secret']);
        $container->setParameter('apnmarketplace.accept_datetime', $config['accept_datetime']);
        $container->setParameter('apnmarketplace.host', $config['host']);
        $container->setParameter('apnmarketplace.guzzle_verify_ssl', $config['guzzle_verify_ssl']);
        $container->getDefinition('apnmarketplace.api_client')->replaceArgument(0, new Reference($config['client']));
        if ($config['guzzle_caching']) {
            $container->getDefinition('apnmarketplace.guzzle_client')->addMethodCall('addSubscriber', array(new Reference('apnmarketplace.guzzle_cache_plugin')));
        }
    }
}
