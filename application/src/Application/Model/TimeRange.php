<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Model;

/**
 * Class TimeRange
 *
 * This value object represents the time ranges within a day.
 *
 * @package Application\Model
 * @author Geza Buza <bghome@gmail.com>
 */
class TimeRange
{
    const MORNING = 'morning';
    const NOON = 'noon';
    const AFTERNOON = 'afternoon';
    const EVENING = 'evening';

    public static function getChoices()
    {
        return [
            self::MORNING => 'timeRange.morning',
            self::NOON => 'timeRange.noon',
            self::AFTERNOON => 'timeRange.afternoon',
            self::EVENING => 'timeRange.evening',
        ];
    }
}
