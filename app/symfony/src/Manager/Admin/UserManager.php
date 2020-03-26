<?php

namespace App\Manager\Admin;

use App\Entity\User;
use App\Event\AdminNotifierUserProfilEvent;
use App\Event\UserUpdateEvent;
use App\Repository\UserRepository;
use App\Services\MailerService;
use App\Services\MessageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var MailerService
     */
    protected $mailerService;

    /**
     * @var \Twig_Environment
     */
    protected $templating;

    /**
     * @var PasswordService
     */
    protected $passwordService;

    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var TypeEmail
     */
    protected $typeEmail;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var PaginatorService
     */
    protected $paginatorService;

    /**
     * @var TranslatorService
     */
    protected $translatorService;

    /**
     * UserManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param MailerService          $mailerService
     * @param MessageService         $messageService
     * @param EventDispatcherInterface $eventDispatcher
     * @param UserRepository         $userRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MailerService $mailerService,
        MessageService $messageService,
        EventDispatcherInterface $eventDispatcher,
        UserRepository $userRepository
    ) {
        $this->em = $entityManager;
        $this->mailerService = $mailerService;
        $this->messageService = $messageService;
        $this->eventDispatcher = $eventDispatcher;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function mailerNotifierProfilUser($id)
    {
        $user = $this->userRepository->find($id);
        if($user instanceof User) {
            $event = new AdminNotifierUserProfilEvent($user);
            $this->eventDispatcher->dispatch($event);

            return $this->messageService->addSuccess('Notification envoyer à : ' . $user->getEmail());
        }

        return $this->messageService->addError('Mail non envoyé. ' . $user->getEmail());
    }

    /**
     * @return mixed
     */
    public function numberAllUser()
    {
        return $this->userRepository->countAllRole(User::ROLE_USER, User::PROFIL_NULL);
    }

    /**
     * @return mixed
     */
    public function numberUserValid()
    {
        return $this->userRepository->countAllRole(User::ROLE_USER, User::PROFIL_VALIDATED);
    }

    /**
     * @return mixed
     */
    public function numberUserNotValid()
    {
        return $this->userRepository->countAllRole(User::ROLE_USER, User::PROFIL_NON_VALIDATED);
    }

    /**
     * @return mixed
     */
    public function numberAllTeacher()
    {
        return $this->userRepository->countAllRole(User::ROLE_TEACHER, User::PROFIL_NULL);
    }

    /**
     * @return mixed
     */
    public function numberTeacherValid()
    {
        return $this->userRepository->countAllRole(User::ROLE_TEACHER, User::PROFIL_VALIDATED);
    }

    /**
     * @return mixed
     */
    public function numberTeacherNotValid()
    {
        return $this->userRepository->countAllRole(User::ROLE_TEACHER, User::PROFIL_NON_VALIDATED);
    }

    /**
     * @return mixed
     */
    public function allUser()
    {
        return $this->userRepository->countAllUser();
    }

    /**
     * @return mixed
     */
    public function numberAllWoman()
    {
        return $this->userRepository->countAllGender(User::STATUS_WOMAN, User::PROFIL_NULL);
    }

    /**
     * @return mixed
     */
    public function numberAllWomanInvalid()
    {
        return $this->userRepository->countAllGender(User::STATUS_WOMAN, User::PROFIL_NON_VALIDATED);
    }

    /**
     * @return mixed
     */
    public function numberAllWomanValid()
    {
        return $this->userRepository->countAllGender(User::STATUS_WOMAN, User::PROFIL_VALIDATED);
    }

    /**
     * @return mixed
     */
    public function numberAllMan()
    {
        return $this->userRepository->countAllGender(User::STATUS_MAN, User::PROFIL_NULL);
    }

    /**
     * @return mixed
     */
    public function numberAllManInvalid()
    {
        return $this->userRepository->countAllGender(User::STATUS_MAN, User::PROFIL_NON_VALIDATED);
    }

    /**
     * @return mixed
     */
    public function numberAllManValid()
    {
        return $this->userRepository->countAllGender(User::STATUS_MAN, User::PROFIL_VALIDATED);
    }
}
