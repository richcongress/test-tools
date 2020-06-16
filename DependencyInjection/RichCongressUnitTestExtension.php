<?php declare(strict_types=1);

namespace RichCongress\UnitTestBundle\DependencyInjection;

use RichCongress\BundleToolbox\Configuration\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RichCongressUnitTestExtension extends AbstractExtension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Nothing to do
    }
}
