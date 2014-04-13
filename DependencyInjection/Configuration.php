<?php

namespace Vitre\PhpConsoleBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('vitre_php_console');

        $rootNode->children()
            ->booleanNode('enabled')
                ->defaultFalse()->end()
            ->scalarNode('driver')
                ->defaultValue('php_console')->end()
            ->scalarNode('source_base_path')
                ->defaultValue('%kernel.root_dir%')->end()
            ->scalarNode('encoding')
                ->defaultValue('%kernel.charset%')->end()
            ->arrayNode('ip')
                ->prototype('scalar')->end()->end()
            ->scalarNode('password')
                ->defaultFalse()->end()
            ->booleanNode('ssl_only')
                ->defaultFalse()->end()
            ->booleanNode('detect_trace_and_source')
                ->defaultFalse()->end()
            ->arrayNode('handle')
                ->cannotBeEmpty()
                ->children()
                    ->booleanNode('errors')
                        ->defaultFalse()->cannotBeEmpty()->end()
                    ->booleanNode('exceptions')
                        ->defaultFalse()->cannotBeEmpty()->end()
                    ->booleanNode('forward')
                        ->defaultTrue()->cannotBeEmpty()->end()
                ->end()
            ->end()
            ->arrayNode('auto_log')
                ->prototype('scalar')->end()->end()
            ->arrayNode('eval_dispatcher')
                ->children()
                    ->booleanNode('enabled')
                        ->defaultFalse()->end()
                    ->arrayNode('shared')
                        ->prototype('scalar')->end()->end()
                    ->arrayNode('open_base_dirs')
                        ->prototype('scalar')->end()->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
