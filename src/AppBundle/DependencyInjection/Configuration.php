<?php
/**
 * Created by arvydas.
 * Date: 4/18/17 - Time: 8:10 PM
 */

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('app');

        $rootNode
            ->children()
                ->scalarNode('provider')->isRequired()->end()
                ->arrayNode('providers')
                    ->children()

                        ->arrayNode('owm')
                            ->children()
                                ->scalarNode('key')->isRequired()->end()
                            ->end()
                        ->end() // owm
                        ->arrayNode('apixu')
                            ->children()
                                ->scalarNode('key')->isRequired()->end()
                            ->end()

                        ->end() // apixu
                        ->arrayNode('delegating')
                            ->children()
                                ->arrayNode('providers')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end() // delegating

                        ->arrayNode('cached')
                            ->children()
                                ->integerNode('lifetime')->isRequired()->end()
                                ->scalarNode('provider')->isRequired()->end()
                            ->end()
                        ->end() // cached

                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}