<?php

namespace Application\Model;

/**
 * Class Reminder
 * @package Application\Model
 * @author Hargitai Dávid <div@diatigrah.hu>
 *
 * @property integer $type
 */
class Reminder extends ValueObject
{
    const TYPE_EMAIL = 1;
    const TYPE_TEXT = 2;
    const TYPE_EMAIL_AND_TEXT = 3;
    const TYPE_NONE = 4;
}
