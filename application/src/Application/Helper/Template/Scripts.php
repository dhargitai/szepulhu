<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Helper\Template;

/**
 * Class Scripts
 *
 * This class represents a list of inline scripts.
 *
 * @package Application\Helper\Template
 * @author Geza Buza <bghome@gmail.com>
 */
class Scripts
{
    /** @var array $scripts List of scripts */
    protected $scripts = [];

    /** @var array $positions Position a script in the list */
    protected $positions = [];

    /** @var bool $stripScriptTag Flag to remove script tags */
    private $stripScriptTags;

    /**
     * @param bool $stripScriptTags When this flag is set the script HTML tag will be removed from the output
     */
    public function __construct($stripScriptTags = false)
    {
        $this->stripScriptTags = $stripScriptTags;
    }

    /**
     * Add the given script to the list
     *
     * @param string $script Script text
     * @param int|null $position Position on the list. Auto increment when not specified.
     */
    public function add($script, $position = null)
    {
        $this->scripts[] = $this->stripScriptTags ? $this->stripScriptTags($script) : $script;
        $this->positions[] = is_null($position) ? $this->max($this->positions) + 1 : $position;

        array_multisort($this->positions, $this->scripts);
    }

    /**
     * Add the script to the list only when it's not already added
     *
     * @param string $script Script text
     * @param int|null $position Position on the list. Auto increment when not specified.
     */
    public function addOnce($script, $position = null)
    {
        if (!in_array($script, $this->scripts)) {
            $this->add($script, $position);
        }
    }

    /**
     * Return true when the list of scripts is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->scripts);
    }

    /**
     * Returns the list of scripts separated by newline
     *
     * @return string
     */
    public function __toString()
    {
        return implode("\n", $this->scripts);
    }

    private function max($array)
    {
        $array[] = 0;
        return max($array);
    }

    private function stripScriptTags($script)
    {
        $start = 0;
        $length = null;

        if (($position = mb_strpos($script, '<script>')) !== false) {
            $start = $position + 8;
        }
        if (($position = mb_strpos($script, '</script>')) !== false) {
            $length = $position - $start;
        }

        return mb_substr($script, $start, $length);
    }
}
