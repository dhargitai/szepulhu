<?php

namespace Application\Controller;

use Application\Entity\Professional\Salon;
use Application\Sonata\MediaBundle\Document\Media;
use Application\Entity\ProfessionalUser;
use Application\Entity\ClientUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $professionalRepository = $this->getDoctrine()->getRepository('AppBundle:ProfessionalUser');

        return $this->render(
            'index.html.twig',
            array('featuredProfessionals' => $professionalRepository->getFeaturedProfessionals())
        );
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
     * @Route("/{professionalSlug}", name="professional_profile", requirements={
     *    "professionalSlug": "[a-zA-Z]+"
     * })
     * @param string $professionalSlug
     *
     * @return Response
     */
    public function professionalProfileAction($professionalSlug)
    {
        $professionalRepository = $this->getDoctrine()->getRepository('AppBundle:ProfessionalUser');
        $professional = $professionalRepository->findOneBy(array('slug' => $professionalSlug));
        return $this->render(
            'professional/profile.html.twig',
            array(
                'professional' => $professional,
                'hasServices'  => $professionalRepository->hasServices($professional->getId())
            )
        );
    }

    /**
     * @Route("/{slug}", name="professional_salon")
     * @param string $slug
     *
     * @return Response
     */
    public function professionalSalon($slug)
    {
        $salon = $this->getDoctrine()->getRepository('AppBundle:Professional\Salon')->findOneBy(
            array('slug' => $slug)
        );
        return $this->render('professional/salon.html.twig', array('salon' => $salon));
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
