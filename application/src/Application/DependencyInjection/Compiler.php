<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Class Compiler
 *
 * This is just a workaround for a bug in Sonata Project's Media Bundle.
 * TODO It can be removed once, this PR is merged https://github.com/sonata-project/SonataMediaBundle/pull/909
 *
 * @package Application\DependencyInjection
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class Compiler implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $twigExtension = $container->getDefinition('sonata.media.twig.extension');
        $twigExtension->setClass('Application\Sonata\MediaBundle\Twig\Extension\MediaExtension');
    }
}