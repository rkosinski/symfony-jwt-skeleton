<?php declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Form\Type\LoginFormType;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    private $userRepository;
    private $router;
    private $formFactory;
    private $passwordEncoder;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getLoginUrl(): string
    {
        return $this->router->generate('security_login');
    }

    public function getCredentials(Request $request): array
    {
        $form = $this->formFactory->create(LoginFormType::class);
        $form->handleRequest($request);

        $data = $form->getData();
        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?User
    {
        $username = $credentials['username'];
        return $this->userRepository->findOneByEmail($username);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $password = $credentials['password'];
        return $this->passwordEncoder->isPasswordValid($user, $password);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): Response
    {
        return new RedirectResponse($this->router->generate('main_index'));
    }

    public function supports(Request $request): bool
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod(Request::METHOD_POST);
        return $isLoginSubmit;
    }
}