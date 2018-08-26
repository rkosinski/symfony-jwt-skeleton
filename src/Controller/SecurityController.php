<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function login(): Response
    {
        $error = $this->get('security.authentication_utils')->getLastAuthenticationError();

        $form = $this->createForm(LoginFormType::class);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}