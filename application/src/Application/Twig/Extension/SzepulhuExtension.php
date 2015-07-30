<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Extension;

/**
 * Class SzepulhuExtension
 *
 * Extending Twig to be able to use custom filters in our template files.
 *
 * @package Application\Twig
 * @author Hargitai Dávid <div@diatigrah.hu>
 */
class SzepulhuExtension extends Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return '';
    }

    public function getFilters()
    {
        return [
            'json_decode' => new \Twig_Filter_Method($this, 'jsonDecode'),
        ];
    }

    public function jsonDecode($str)
    {
        return json_decode($str);
    }
}
