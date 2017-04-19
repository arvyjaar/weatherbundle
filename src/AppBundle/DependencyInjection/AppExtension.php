<?php
/**
 * Created by arvydas.
 * Date: 4/18/17 - Time: 8:07 PM
 */

namespace AppBundle\DependencyInjection;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class AppExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setAlias('app.provider', 'app.provider.'.$config['provider']);

        // foreach...
        if (isset($config['providers']['owm']['key'])) {
            $container->getDefinition('app.provider.owm')
                ->replaceArgument(0, $config['providers']['owm']['key']);
        }
        if (isset($config['providers']['apixu']['key'])) {
            $container->getDefinition('app.provider.apixu')
                ->replaceArgument(0, $config['providers']['apixu']['key']);
        }
        if (isset($config['providers']['delegating'])) {
            $container->getDefinition('app.provider.delegating')
                ->replaceArgument(0, $config['providers']['delegating']['providers'][0]);
            $container->getDefinition('app.provider.delegating')
                ->replaceArgument(1, $config['providers']['delegating']['providers'][1]);
        }

    }
}