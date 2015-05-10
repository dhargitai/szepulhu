<?php
/**
 *
 *
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.02.21.
 * @package   SzepulHu_Model
 */

namespace Application\Model;


interface Professional
{
    const INTEREST_FREE_APPOINTMENT_SCHEDULING = 'free_appointment_scheduling';
    const INTEREST_FREE_WEBSITE_AND_ONLINE_MARKETING = 'free_website_and_online_marketing';
    const INTEREST_FREE_CLIENT_TRACKING = 'free_client_tracking';
    const INTEREST_GROW_AND_SIMPLIFY_BUSINESS = 'grow_and_simplify_business';
    const INTEREST_NOT_SURE = 'not_sure';

    const PREFERRED_PHONE_SALON = 'salon';
    const PREFERRED_PHONE_PERSONAL = 'personal';
}
