<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\MediaBundle\Twig\Extension;

/**
 * Class MediaExtension
 *
 * This is just a workaround for a bug in Sonata Project's Media Bundle.
 * TODO It can be removed once, this PR is merged https://github.com/sonata-project/SonataMediaBundle/pull/909
 *
 * @package Application\Sonata\MediaBundle\Twig\Extension
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class MediaExtension extends \Sonata\MediaBundle\Twig\Extension\MediaExtension
{
    /**
     * Returns the thumbnail for the provided media.
     *
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     * @param string                                   $format
     * @param array                                    $options
     *
     * @return string
     */
    public function thumbnail($media = null, $format, $options = array())
    {
        if (!$media) {
            return '';
        }

        $provider = $this->getMediaService()
            ->getProvider($media->getProviderName());

        $format = $provider->getFormatName($media, $format);
        $format_definition = $provider->getFormat($format);

        // build option
        $defaultOptions = array(
            'title' => $media->getName(),
        );

        if ($format_definition['width']) {
            $defaultOptions['width'] = $format_definition['width'];
        }
        if ($format_definition['height']) {
            $defaultOptions['height'] = $format_definition['height'];
        }

        $options = array_merge($defaultOptions, $options);

        $options = $provider->getHelperProperties($media, $format, $options);

        return $this->render($provider->getTemplate('helper_thumbnail'), array(
            'media'    => $media,
            'options'  => $options,
        ));
    }
}