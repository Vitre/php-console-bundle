<?php

namespace Vitre\PhpConsoleBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class VitrePhpConsoleExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('vitre_php_console.enabled', $config['enabled']);
        $container->setParameter('vitre_php_console.source_base_path', $config['source_base_path']);
        $container->setParameter('vitre_php_console.encoding', $config['encoding']);
        $container->setParameter('vitre_php_console.ip', $config['ip']);
        $container->setParameter('vitre_php_console.password', $config['password']);
        $container->setParameter('vitre_php_console.ssl_only', $config['ssl_only']);
        $container->setParameter('vitre_php_console.detect_trace_and_source', $config['detect_trace_and_source']);
        $container->setParameter('vitre_php_console.handle.errors', $config['handle']['errors']);
        $container->setParameter('vitre_php_console.handle.exceptions', $config['handle']['exceptions']);
        $container->setParameter('vitre_php_console.handle.forward', $config['handle']['forward']);
        $container->setParameter('vitre_php_console.auto_log', $config['auto_log']);
        $container->setParameter('vitre_php_console.eval_dispatcher.enabled', $config['eval_dispatcher']['enabled']);
        $container->setParameter('vitre_php_console.eval_dispatcher.shared', $config['eval_dispatcher']['shared']);
        $container->setParameter('vitre_php_console.eval_dispatcher.open_base_dirs', $config['eval_dispatcher']['open_base_dirs']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
