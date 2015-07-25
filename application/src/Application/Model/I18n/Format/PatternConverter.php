<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Model\I18n\Format;

use RuntimeException;

/**
 * Class PatternConverter
 *
 * The purpose of this class is to allow conversion between date or datetime formats.
 * For list of available conversions see the "i18n.format.pattern_map" parameter in YAML configuration.
 *
 * @package Application\Model\I18n\Format
 * @author Geza Buza <bghome@gmail.com>
 */
class PatternConverter
{
    /** @var  PatternMap[] $mappings List of mappings */
    private $mappings;

    /**
     * Constructor
     *
     * @param array $config Defines the list of mappings. Expected keys are
     * - source: source format identifier
     * - destination: destination format identifier
     * - mapping: keys are the characters in the source format, values are their equivalent in the destination format
     */
    public function __construct(array $config)
    {
        $this->mappings = $this->createMappings($config);
    }

    /**
     * Converts the given pattern to the destination format
     *
     * @param string $source
     * @param string $destination
     * @param string $pattern
     * @return string
     */
    public function convert($source, $destination, $pattern)
    {
        foreach ($this->mappings as $map) {
            if ($map->getSource() === $source && $map->getDestination() === $destination) {
                return $this->convertPattern($pattern, $map->getMapping());
            }
        }

        throw new RuntimeException(sprintf('There is no pattern mapping from "%s" to "%s".', $source, $destination));
    }

    /**
     * Translate the pattern to the new format
     *
     * @param string $pattern
     * @param array $mapping
     * @return string
     */
    protected function convertPattern($pattern, array $mapping)
    {
        return strtr($pattern, $mapping);
    }

    private function createMappings(array $config)
    {
        $mappings = [];
        foreach ($config as $map) {
            $mappings[] = new PatternMap($map['source'], $map['destination'], $map['mapping']);
        }
        return $mappings;
    }
}
