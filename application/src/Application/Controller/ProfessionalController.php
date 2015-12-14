<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Controller;

use Application\Entity\ProfessionalUser;
use Application\Entity\ProfessionalUserRepository;
use Application\Form\Type\Professional\ServiceSearch;
use Application\Interactor\ProfessionalProfileInteractor;
use Application\Interactor\ProfessionalProfileRequest;
use Application\Interactor\ProfessionalSearchInteractor;
use Application\Interactor\SalonInteractor;
use Application\Interactor\SalonRequest;
use Application\Model\Professional\ServiceSearchParameters;
use Application\Symfony\Component\Routing\Generator\AutoMatchUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProfessionalController
 *
 * @package Application\Controller
 * @author Dávid Hargitai <div@diatigrah.hu>
 * @author Geza Buza <bghome@gmail.com>
 *
 * @Route(service="app.professional_controller")
 */
class ProfessionalController extends Controller
{
    const NUMBER_OF_PROFESSIONALS_PER_PAGE = 5;

    private $templating;
    private $profileInteractor;
    private $salonInteractor;

    public function __construct(
        EngineInterface $templating,
        ProfessionalProfileInteractor $professionalInteractor,
        SalonInteractor $salonInteractor
    )
    {
        $this->templating = $templating;
        $this->profileInteractor = $professionalInteractor;
        $this->salonInteractor = $salonInteractor;
    }

    /**
     * @Route("/{professionalSlug}", name="professional_profile", requirements={
     *    "professionalSlug": "[a-zA-Z]+"
     * })
     * @param string $professionalSlug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction($professionalSlug)
    {
        $response = $this->profileInteractor->createProfessionalProfileResponse(
            new ProfessionalProfileRequest($professionalSlug)
        );
        return $this->templating->renderResponse(
            'professional/profile.html.twig',
            $response->asArray()
        );
    }

    /**
     * @Route("/{slug}", name="professional_salon")
     * @param string $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function professionalSalon($slug)
    {
        $response = $this->salonInteractor->createSalonResponse(
            new SalonRequest($slug)
        );
        return $this->templating->renderResponse(
            'professional/salon.html.twig',
            $response->asArray()
        );
    }

    /**
     * @Route("/service/search", name="service_search")
     * @Route("/service/search/name/{name}")
     * @Route("/service/search/location/{location}")
     * @Route("/service/search/date/{date}")
     * @Route("/service/search/time/{time}")
     * @Route("/service/search/name/{name}/location/{location}")
     * @Route("/service/search/name/{name}/date/{date}")
     * @Route("/service/search/name/{name}/time/{time}")
     * @Route("/service/search/location/{location}/date/{date}")
     * @Route("/service/search/location/{location}/time/{time}")
     * @Route("/service/search/date/{date}/time/{time}")
     * @Route("/service/search/name/{name}/location/{location}/date/{date}")
     * @Route("/service/search/name/{name}/location/{location}/time/{time}")
     * @Route("/service/search/name/{name}/date/{date}/time/{time}")
     * @Route("/service/search/location/{location}/date/{date}/time/{time}")
     * @Route("/service/search/name/{name}/location/{location}/date/{date}/time/{time}")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $searchParameters = new ServiceSearchParameters();

        $form = $this->createForm(new ServiceSearch(), $searchParameters);

        $form->handleRequest($request);

        $templateParameters = ['searchForm' => $form->createView()];

        if ($request->getMethod() === 'POST' && $form->isValid()) {
            $url = $this->generateUrl(
                'app.professional_controller:search', iterator_to_array($searchParameters),
                AutoMatchUrlGenerator::REFERENCE_TYPE
            );
            return $this->redirect($url);
        }

        if ($form->isValid()) {
            $professionals = (new ProfessionalSearchInteractor($this->get('app.professional_repository')))
                ->createSearchQuery($searchParameters);
            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $professionals, $request->query->getInt('page', 1), self::NUMBER_OF_PROFESSIONALS_PER_PAGE
            );

            $templateParameters['pagination'] = $pagination;
        }

        return $this->render(':professional:service_results.html.twig', $templateParameters);
    }
}
