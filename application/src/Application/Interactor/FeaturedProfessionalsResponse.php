<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class FeaturedProfessionalsResponse
 * @package Application\Interactor
 *
 * @property array featuredProfessionals
 * @property int numberOfFeaturedProfessionals
 * @property array location Array having "type" and "name" attributes
 */
class FeaturedProfessionalsResponse extends ValueObject
{
}
