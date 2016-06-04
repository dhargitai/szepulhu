<?php

/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Controller\RestApi;

use FOS\RestBundle\Controller\Annotations\Get;
use Application\Interactor\Location;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;


/**
 * Class ProfessionalsController
 *
 * Provide information about professional users.
 *
 * @package Application\Controller\RestApi
 *
 * @author Geza Buza <bghome@gmail.com>
 */
class ProfessionalsController extends FOSRestController implements ClassResourceInterface
{
    const MAX_RESULT_ITEMS = 20;

    /**
     * Return the array of user IDs
     *
     * @param string $county
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Get("/professionals/featured/{county}/county")
     */
    public function getFeaturedCountyAction($county)
    {
        $location = new Location(Location::TYPE_COUNTY, $county);
        $users = $this->get('app.professional_repository')
            ->getFeaturedProfessionalsByLocation($location, self::MAX_RESULT_ITEMS);

        $result = array_map(
            function($user) {
                return $user->getId();
            },
            $users
        );

        $view = $this->view(['ids' => $result], 200);

        return $this->handleView($view);
    }
}