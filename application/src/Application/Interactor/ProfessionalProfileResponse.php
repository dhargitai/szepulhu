<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.25.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Model\ValueObject;

/**
 * Class ProfessionalProfileResponse
 * @package Application\Interactor
 *
 * @property boolean $hasServices
 * @property string $firstName
 * @property string $lastName
 * @property string $profession
 * @property string $profilePicture
 * @property \Application\Entity\Professional\Salon $salon
 * @property string $biography
 * @property string $gallery
 * @property string $slug
 * @property \Application\Entity\Professional\ServiceGroup[] $serviceGroups
 * @property \Application\Entity\Professional\Recommendation[] $recommendations
 * @property string $website
 * @property string $blogPage
 * @property string $facebookPage
 * @property string $twitterAccount
 */
class ProfessionalProfileResponse extends ValueObject
{
}
