<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

class HomepageResponse
{
    public function __construct(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->$name = $value;
        }
    }
}
