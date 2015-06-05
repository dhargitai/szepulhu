<?php

namespace Application\Controller;

use Application\Interactor\ProfessionalProfileInteractor;
use Application\Interactor\ProfessionalProfileRequest;
use Application\Interactor\SalonInteractor;
use Application\Interactor\SalonRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * @Route(service="app.professional_controller")
 */
class ProfessionalController
{
    private $templating;
    private $profileInteractor;
    private $salonInteractor;

    public function __construct(
        EngineInterface $templating,
        ProfessionalProfileInteractor $professionalInteractor,
        SalonInteractor $salonInteractor
    ) {
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
            new ProfessionalProfileRequest(array('slug' => $professionalSlug))
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
            new SalonRequest(array('slug' => $slug))
        );
        return $this->templating->renderResponse(
            'professional/salon.html.twig',
            $response->asArray()
        );
    }
}
