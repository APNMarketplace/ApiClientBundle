<?php

namespace ApnMarketplace\ApiClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('apnmarketplace_api_client');

        $rootNode->children()
            ->scalarNode('id')->defaultValue('')->end()
            ->scalarNode('secret')->defaultValue('')->end()
            ->scalarNode('client')->defaultValue('apnmarketplace.guzzle_client')->end()
            ->scalarNode('host')->defaultValue('https://api.apnmarketplace.co.nz')->end()
            ->booleanNode('guzzle_verify_ssl')->defaultTrue()->end()
            ->booleanNode('guzzle_caching')->defaultTrue()->end()
        ->end();

        return $treeBuilder;
    }
}
