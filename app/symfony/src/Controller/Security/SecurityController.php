<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\Security\LoginType;
use App\Form\Security\RegisterType;
use App\Form\Security\RequestType;
use App\Form\Security\ResetType;
use App\Manager\TokenManager;
use App\Manager\UserManager;
use App\Services\MessageService;
use App\Services\TokenService;
use App\Services\TranslatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin_74ze5f/login", name="admin_login", methods={"GET","POST"})
     * @param AuthenticationUtils $authUtils
     * @return Response
     */
    public function admin(AuthenticationUtils $authUtils): Response
    {
        $form = $this->createForm(LoginType::class, [
            '_username' => $authUtils->getLastUsername(),
        ]);

        return $this->render('security/login.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'admin' => 'Admin',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/login", name="login", methods={"GET","POST"})
     * @param AuthenticationUtils $authUtils
     * @param Request $request
     * @param MessageService $messageService
     * @param UserManager $userManager
     * @param TokenManager $tokenManager
     * @return Response
     * @throws \Exception
     */
    public function user(
        AuthenticationUtils $authUtils,
        Request $request,
        MessageService $messageService,
        UserManager $userManager,
        TokenManager $tokenManager,
        TranslatorService $translatorService
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        $form = $this->createForm(LoginType::class, [
            '_username' => $authUtils->getLastUsername(),
        ]);

        $formRequestPassword = $this->createForm(RequestType::class, null);
        $formRequestPassword->handleRequest($request);

        if ($formRequestPassword->isSubmitted() && $formRequestPassword->isValid()) {
            $user = $userManager->loadByUsername($formRequestPassword->getData()['_username']);

            if ($user instanceof User) {
                $tokenManager->create($user);
                $messageService->addSuccess($translatorService->translate('message.flash.resetpasswordsave'));
            } else {
                $messageService->addError($translatorService->translate('message.flash.resetpasswordnosave'));
            }
        }

        return $this->render('security/login.html.twig', [
            'error' => $authUtils->getLastAuthenticationError(),
            'form' => $form->createView(),
            'admin' => '',
            'formRequestPassword' => $formRequestPassword->createView()
        ]);
    }

    /**
     * @Route("/user/register", name="register", methods={"GET", "POST"})
     * @param Request $request
     * @param UserManager $userManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function register_user(
        Request $request,
        UserManager $userManager
    ) {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $user->setRole(User::ROLE_USER);

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->getHost() != 'localhost') {
                $hostname = 'https://devsprof.fr';
            }else{
                $hostname = 'http://'.$request->getHttpHost();
            }
            $userManager->registerAccount($user, $hostname);

            return $this->redirectToRoute('register');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/teacher/register", name="register_teacher", methods={"GET", "POST"})
     * @param Request $request
     * @param UserManager $userManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function register_teacher(
        Request $request,
        UserManager $userManager
    ) {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $user = new User();
        $user->setRole(User::ROLE_TEACHER);

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->getHost() != 'localhost') {
                $hostname = 'https://devsprof.fr';
            }else{
                $hostname = 'http://'.$request->getHttpHost();
            }
            $userManager->registerAccount($user, $hostname);

            return $this->redirectToRoute('register');
        }

        return $this->render('security/register_teacher.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     * @param MessageService $messageService
     * @param UserManager $userManager
     * @param string $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activation(
        MessageService $messageService,
        UserManager $userManager,
        string $token
    ) {
        $user = $userManager->checkToken($token);

        if ($user instanceof User) {
            $userManager->activeUser($user);
        }

        $messageService->addSuccess('Cet token d\'activation est invalide.');

        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/user/password/reset/{reference}", name="user_reset", methods={"GET","POST"})
     * @param string $reference
     * @param Request $request
     * @param MessageService $messageService
     * @param TokenService $tokenService
     * @param UserManager $userManager
     * @param TranslatorService $translatorService
     * @return Response
     * @throws \Exception
     */
    public function reset(
        string $reference,
        Request $request,
        MessageService $messageService,
        TokenService $tokenService,
        UserManager $userManager,
        TranslatorService $translatorService
    ): Response {
        if (!$tokenService->isValid($reference)) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ResetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $userManager->setPassword($reference, $data['password']);
            $messageService->addSuccess($translatorService->translate('message.flash.resetpassword'));

            return $this->redirectToRoute('login');
        }

        return $this->render('security/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin_74ze5f/logout", name="admin_logout", methods={"GET"})
     * @Route("/user/logout", name="user_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}