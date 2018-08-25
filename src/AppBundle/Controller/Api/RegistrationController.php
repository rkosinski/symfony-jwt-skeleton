<?php declare(strict_types=1);

namespace AppBundle\Controller\Api;

use AppBundle\Controller\BaseFosRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\RestBundle\Controller\Annotations as FOS;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends BaseFosRestController
{
    /**
     * @ApiDoc(resource=true, description="Registration route", views={"default", "authentication"})
     * @FOS\Post("/register", name="api_v1_user_register")
     */
    public function registerAction(Request $request): Response
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $this->get('event_dispatcher')->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event = new GetResponseUserEvent($user, $request));

        if (null !== $event->getResponse()) {
            return $this->handleView($this->view(null, Response::HTTP_BAD_REQUEST));
        }

        $form = $this->get('fos_user.registration.form.factory')->createForm(['csrf_protection' => false]);
        $form->setData($user);

        if (null === $data = json_decode($request->getContent(), true)) {
            return $this->handleView($this->view(null, Response::HTTP_BAD_REQUEST));
        }

        if (false === $form->submit($data)->isValid()) {
            return $this->handleView($this->view(['form' => $this->getErrorsFromForm($form)], Response::HTTP_BAD_REQUEST));
        }

        $this->get('event_dispatcher')->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, new FormEvent($form, $request));
        $userManager->updateUser($user);

        return $this->handleView($this->view(null, Response::HTTP_CREATED));
    }
}