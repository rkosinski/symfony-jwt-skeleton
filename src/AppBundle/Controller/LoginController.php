<?php declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Utils\BaseFosRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as FOS;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends BaseFosRestController
{
    /**
     * @ApiDoc(resource=true, description="Login route", views={"default", "authentication"})
     * @FOS\Post("/login", name="api_v1_user_login")
     */
    public function loginAction() : Response
    {
        return $this->forward('FOSUserBundle:Security:login');
    }
}