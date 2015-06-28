<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Model\I18n\Format;

/**
 * Class PatternMap
 *
 * This class represents a date or datetime format mapping.
 *
 * @package Application\Model\I18n\Format
 * @author Geza Buza <bghome@gmail.com>
 */
class PatternMap
{
    /** @var array $mapping Associative array for storing source to destination pattern elements */
    private $mapping;

    /** @var string $source Name of the source pattern format */
    private $source;

    /** @var  string $destination Name of the destination pattern format */
    private $destination;

    public function __construct($source, $destination, array $mapping)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->mapping = $mapping;
    }

    /**
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }
}
