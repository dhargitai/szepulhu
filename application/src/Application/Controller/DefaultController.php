<?php
/**
 * This file is part of the szepul.hu application.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Controller;

use Application\Entity\Professional\Salon;
use Application\Entity\ProfessionalUserRepository;
use Application\Interactor\Location;
use Application\Interactor\LocationRequest;
use Application\Interactor\FeaturedProfessionalsRequest;
use Application\Interactor\HomepageInteractor;
use Application\Interactor\HomepageRequest;
use Application\Model\Professional\ServiceSearchParameters;
use Application\Sonata\MediaBundle\Document\Media;
use Application\Entity\ProfessionalUser;
use Application\Entity\ClientUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(service="app.default_controller")
 */
class DefaultController
{
    private $templating;
    private $interactor;

    const LOCATION_COOKIE_NAME = 'location';

    public function __construct(EngineInterface $templating, HomepageInteractor $interactor)
    {
        $this->templating = $templating;
        $this->interactor = $interactor;
    }

    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function indexAction()
    {
        $searchParameters = new ServiceSearchParameters();
        $response = $this->interactor->createResponse(new HomepageRequest($searchParameters));
        return $this->templating->renderResponse(
            'index.html.twig',
            $response->asArray()
        );
    }

    /**
     * @Route("/embedded_featured_professionals", name="embedded_featured_professionals")
     * @param Request $request
     *
     * @return Response
     */
    public function embeddedFeaturedProfessionalsAction(Request $request)
    {
        $response = $this->interactor->createFeaturedProfessionalsResponse(
            $this->createFeaturedProfessionalsRequest($request)
        );
        $httpResponse = $this->templating->renderResponse(
            '_featuredProfessionals.html.twig',
            $response->asArray()
        );
        $locationCookie = new Cookie(self::LOCATION_COOKIE_NAME, json_encode($response->location->asArray()));
        $httpResponse->headers->setCookie($locationCookie);
        return $httpResponse;
    }

    private function createFeaturedProfessionalsRequest(Request $request)
    {
        $locationData = $request->request->get(self::LOCATION_COOKIE_NAME) ?: (array)json_decode($request->cookies->get(
            self::LOCATION_COOKIE_NAME
        ));
        return new FeaturedProfessionalsRequest(
            LocationRequest::createFromArray($locationData),
            $request->request->get('numberOfFeaturedProfessionals', 6)
        );
    }

    /**
     * @Route("/get_closest_location", name="get_closest_location", options={"expose"=true})
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getCurrentLocationAction(Request $request)
    {
        $response = new JsonResponse();
        $response->setData(
            [
                self::LOCATION_COOKIE_NAME => $this->interactor->createClosestFeaturedProfessionalsLocationResponse(
                    LocationRequest::createFromArray(
                        [
                            'latitude'  => $request->get('latitude'),
                            'longitude' => $request->get('longitude'),
                            'ip'        => $request->getClientIp(),
                        ]
                    )
                )->asArray()
            ]
        );
        return $response;
    }

    /**
     * @Route("/vallalkozasoknak", name="professional_registration_flow")
     *
     * @return Response
     */
    public function professionalRegistrationAction()
    {
        $discriminator = $this->container->get('pugx_user.manager.user_discriminator');
        $discriminator->setClass('Application\Entity\ProfessionalUser');
        $userManager = $this->container->get('pugx_user_manager');
        $formData = $userManager->createUser();


        $flow = $this->get('app.form.flow.register_professional');
        $flow->bind($formData);

        // form of the current step
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $formData->setName($formData->getLastName() . " " . $formData->getFirstName());
                $userManager->updateUser($formData, true);

                $flow->reset(); // remove step data from the session

                return $this->redirect($this->generateUrl('home')); // redirect when done
            }
        }
        $result = $this->sumFormData($this->get('session')->get('flow_registerProfessionalFlow_data'));
        return $this->render(
            ':professional:registration.html.twig',
            array(
                'form'   => $form->createView(),
                'flow'   => $flow,
                'result' => $result,
            )
        );
    }

    protected function sumFormData(array $formData = null)
    {
        $result = array();
        if (!is_null($formData)) {
            foreach ($formData as $step) {
                foreach ($step as $key => $data) {
                    $result[$key] = $data;
                }
            }
        }
        return $result;
    }

    /**
     * @Route("/{professionalSlug}/foto/{photoId}", name="professional_photo")
     * @param string  $professionalSlug
     * @param integer $photoId
     *
     * @return Response
     */
    public function professionalPhoto($professionalSlug, $photoId)
    {
        $professionalRepository = $this->getDoctrine()->getRepository('AppBundle:ProfessionalUser');
        if (!$professionalRepository->professionalOwnsPhoto($professionalSlug, $photoId)) {
            throw $this->createNotFoundException();
        }
        $photoRepository = $this->getDoctrine()->getRepository('ApplicationSonataMediaBundle:Media');
        return $this->render(
            'professional/photo.html.twig',
            array('photo'        => $photoRepository->find($photoId),
                  'professional' => $professionalRepository->findOneBy(
                      array('slug' => $professionalSlug)
                  )
            )
        );
    }
}
