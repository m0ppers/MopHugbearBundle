<?php

namespace Mop\HugbearBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MopHugbearExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('mop_hugbear.autoplay', (bool) $config['autoplay']);
        $container->setParameter('mop_hugbear.objname', 'hugit' . uniqid());

        $hugbearConfig = array();
        foreach (array('hugbears', 'minspeed', 'maxspeed', 'minrotation', 'maxrotation') as $option) {
            $hugbearConfig[$option] = (float) $config[$option];
        }
        $hugbearConfig['text'] = $config['text'];
        $hugbearConfig['fontfamily'] = $config['fontfamily'];
        $hugbearConfig['fontsize'] = (int) $config['fontsize'];
        $hugbearConfig['mintextshow'] = (int) $config['mintextshow'];
        $hugbearConfig['maxtextshow'] = (int) $config['maxtextshow'];
        $hugbearConfig['talkingbears'] = (int) $config['talkingbears'];
        
        if ($hugbearConfig['talkingbears'] > $hugbearConfig['hugbears']) {
            throw new \InvalidArgumentException('Talking bears may not be greater than the number of hugbears!');
        }
        foreach (array('speed', 'rotation', 'textshow') as $option) {
            if ($hugbearConfig['min' . $option] < 0) {
                throw new \InvalidArgumentException('min' . $option . ' must be at least 0');
            }
            if ($hugbearConfig['min' . $option] > $hugbearConfig['max' . $option]) {
                throw new \InvalidArgumentException('max' . $option . ' must be greater or equal than min' . $option);
            }
        }
        if ($hugbearConfig['fontsize'] <= 0) {
            throw new \InvalidArgumentException('Fontsize must be > 0');
        }

        $container->setParameter('mop_hugbear.hugbearconfig', $hugbearConfig);
        
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('hugbear.xml');
    }
}
