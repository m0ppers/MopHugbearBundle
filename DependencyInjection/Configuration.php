<?php

namespace Mop\HugbearBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('mop_hugbear');

        $rootNode
            ->children()
                ->scalarNode('autoplay')->defaultFalse()->end()
                ->scalarNode('hugbears')->defaultValue(100)->end()
                ->scalarNode('minspeed')->defaultValue(0.5)->end()
                ->scalarNode('maxspeed')->defaultValue(2)->end()
                ->scalarNode('minrotation')->defaultValue(0.001)->end()
                ->scalarNode('maxrotation')->defaultValue(0.1)->end()
            ->end();

        return $treeBuilder;
    }
}
