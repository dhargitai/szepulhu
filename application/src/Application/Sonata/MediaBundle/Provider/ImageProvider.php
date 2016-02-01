<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Class ImageProvider
 * @package Application\Sonata\MediaBundle\Provider
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ImageProvider extends \Sonata\MediaBundle\Provider\ImageProvider
{
    /**
     * {@inheritdoc}
     */
    public function getHelperProperties(MediaInterface $media, $format, $options = array())
    {
        $newSrcAttribute = '';
        if (isset($options['lazyLoadAttribute'])) {
            $newSrcAttribute = $options['lazyLoadAttribute'];
            unset($options['lazyLoadAttribute']);
        }

        $properties = parent::getHelperProperties($media, $format, $options);

        if (!empty($newSrcAttribute)) {
            $properties[$newSrcAttribute] = $properties['src'];
            $properties['src'] = '#';
        }

        return $properties;
    }
}