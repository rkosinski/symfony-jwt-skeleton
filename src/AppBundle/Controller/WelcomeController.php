<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Utils\BaseFosRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations as FOS;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class WelcomeController extends BaseFosRestController
{
    /**
     * @ApiDoc(resource=true, description="Welcome message for authorized user", views={"default", "authorized"},
     *     headers={
     *         {
     *             "name"="Authorization",
     *             "description"="Authorization key (example: Bearer auth_key)",
     *             "required"=true
     *         }
     *     }
     * )
     * @FOS\Get("/authorized/welcome", name="api_v1_authorized_welcome")
     */
    public function welcomeAction() : Response
    {
        $loggedUser = $this->getUser();
        return $this->handleView($this->view($loggedUser->getUsername(), Response::HTTP_OK));
    }
}