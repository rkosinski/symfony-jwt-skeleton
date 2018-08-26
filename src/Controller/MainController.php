<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends Controller
{
    public function hello(): Response
    {
        return $this->render('main/index.html.twig');
    }

    public function login(): Response
    {
        $error = $this->get(AuthenticationUtils::class)->getLastAuthenticationError();

        $form = $this->createForm(LoginFormType::class);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}