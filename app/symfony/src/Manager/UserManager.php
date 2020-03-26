<?php

namespace App\Manager;

use App\Entity\MediaProfil;
use App\Entity\Availability;
use App\Entity\Solde;
use App\Entity\User;
use App\Event\UserEvent;
use App\Event\UserUpdateEvent;
use App\Repository\UserRepository;
use App\Services\MailerService;
use App\Services\MessageService;
use App\Services\PaginatorService;
use App\Services\PasswordService;
use App\Services\TranslatorService;
use App\Services\TypeEmail;
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
     * @param \Twig_Environment      $templating
     * @param PasswordService        $passwordService
     * @param MessageService         $messageService
     * @param EventDispatcherInterface $eventDispatcher
     * @param TypeEmail              $typeEmail
     * @param UserRepository         $userRepository
     * @param PaginatorService       $paginatorService
     * @param TranslatorService      $translatorService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MailerService $mailerService,
        \Twig_Environment $templating,
        PasswordService $passwordService,
        MessageService $messageService,
        EventDispatcherInterface $eventDispatcher,
        TypeEmail $typeEmail,
        UserRepository $userRepository,
        PaginatorService $paginatorService,
        TranslatorService $translatorService
    ) {
        $this->em = $entityManager;
        $this->mailerService = $mailerService;
        $this->templating = $templating;
        $this->passwordService = $passwordService;
        $this->messageService = $messageService;
        $this->eventDispatcher = $eventDispatcher;
        $this->typeEmail = $typeEmail;
        $this->userRepository = $userRepository;
        $this->paginatorService = $paginatorService;
        $this->translatorService = $translatorService;
    }

    /**
     * @param array|null  $filters
     * @param null|string $role
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function collect(?array $filters, ?string $role)
    {
        return $this->paginatorService->paginate(
            $this->userRepository->search($filters, $role),
            PaginatorService::DEFAULT_LIMIT,
            PaginatorService::DEFAULT_PAGE
        );
    }

    /**
     * @param $username
     * @return User|null
     */
    public function loadByUsername($username): ?User
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }

    /**
     * @param string $reference
     * @param string $password
     */
    public function setPassword(string $reference, string $password): void
    {
        $user = $this->userRepository->findOneBy(['reference' => $reference]);

        $user->setPassword($this->passwordService->encode($user, trim($password)));
        $this->em->flush();
    }

    /**
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function update(User $user)
    {
        $user->setUpdated(new \DateTime());
        $this->em->flush();

        $event = new UserUpdateEvent($user);
        $this->eventDispatcher->dispatch($event);

        return $this->messageService->addSuccess('Modification enregistrée.');
    }

    /**
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function removeIlltimate(User $user)
    {
        $user->setEmail('#####################@...........');
        $user->setUsername('#########################');
        $user->setPrenom('#####################');
        $user->setPassword('#####################');
        $user->setNom('#####################');
        $user->setNumero('#####################');
        $user->setAddress('#####################');
        $user->setGenre('################################');
        $user->setUpdated(new \DateTime());
        $user->setDeleted(new \DateTimeImmutable());
        $this->em->persist($user);
        $this->em->flush();

        return $this->messageService->addSuccess('Suppression enregistrée.');
    }

    /**
     * @param User $user
     * @return mixed
     * @throws \Exception
     */
    public function deleted(User $user)
    {
        $user->setDeleted(new \DateTime());
        $this->em->flush();

        return $this->messageService->addError('Compte supprimer.');
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function editAccount(User $user)
    {
        if ($user instanceof User) {
            $user->setUpdated(new \DateTime());
        }

        $this->em->flush();
    }

    /**
     * @param User   $user
     * @param string $password
     */
    public function editPassword(User $user, string $password)
    {
        if ($user instanceof User) {
            $user->setPassword($this->passwordService->encode($user, $password));
            $this->em->flush();
        }
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user) {
            return $user[0];
        }

        return null;
    }

    /**
     * @param string $reference
     * @return null
     */
    public function findByReference(string $reference)
    {
        $user = $this->userRepository->findByReference($reference);

        if ($user) {
            return $user[0];
        }

        return null;
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function checkToken(string $token)
    {
        $user = $this->userRepository->findByReference($token);

        if (!$user) {
            return null;
        }

        if ($user[0] instanceof User) {
            return $user[0];
        }

        return null;
    }

    /**
     * @param User $user
     */
    public function enable_password_dispatch(User $user)
    {
        $step = false;

        if ($step == false) {
            $user->setPasswordDispatch($user->getPassword());
            $step = true;
        }

        if ($step == true) {
            $user->setPassword($this->passwordService->encode($user, User::KEY_PASSWORD_DISPATCH));
        }

        $this->em->flush();
    }

    /**
     * @param User $user
     */
    public function disabled_password_dispatch(User $user)
    {
        $user->setPassword($user->getPasswordDispatch());
        $user->setPasswordDispatch(null);
        $this->em->flush();
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function resetPassword(User $user)
    {
        $user->setPassword($this->passwordService->encode($user, $user->getPassword()));
        $this->em->flush();

        return $this->messageService->addSuccess($this->translatorService->translate('message.flash.updatepassword'));
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function activeUser(User $user)
    {
        if ($user->getActive() !== 1) {
            $user->setActive(1);
            $this->em->flush();

            $this->eventDispatcher->dispatch(
                UserEvent::USER_CONFIRMED,
                new UserEvent($user, null)
            );

            $this->eventDispatcher->dispatch(
                UserEvent::ADMIN_CONFIRMED,
                new UserEvent($user, null)
            );

            return $this->messageService->addSuccess('Votre est compte maintenant validé.');
        }

        return $this->messageService->addError('Votre compte est déjà validé.');
    }

    /**
     * @param User $user
     * @param string|null $hostname
     * @return mixed
     * @throws \Exception
     */
    public function registerAccount(User $user, ?string $hostname)
    {
        if ($this->findByEmail($user->getEmail())) {
            return $this->messageService->addError('Cette adresse email a déjà été utilisé.');
        }

        $user->setUsername($user->getEmail());
        $user->setCreated(new \DateTime());
        $user->setUpdated(new \DateTime());
        $pass = $this->passwordService->encode($user, $user->getPassword());
        $user->setPassword($pass);
        $user->setReference($this->referenceFormat());
        $user->setValidated(0);

        $media_profil = new MediaProfil();
        $media_profil->setCreated(new \DateTime());
        $media_profil->setUpdated(new \DateTime());
        $user->setMediaProfil($media_profil);

        $solde = new Solde();
        $solde->setTimeUser(0);
        $solde->setTimeTeacher(0);
        $solde->setCreated(new \DateTime());
        $solde->setUpdated(new \DateTime());
        $user->setSolde($solde);

        $availability = new Availability();
        $availability->setCreated(new \DateTime());
        $availability->setUpdated(new \DateTime());
        $user->setAvailability($availability);

        $this->em->persist($solde);
        $this->em->persist($availability);
        $this->em->persist($media_profil);
        $this->em->persist($user);
        $this->em->flush();

        $this->eventDispatcher->dispatch(
            UserEvent::USER_SUBSCRIBED,
            new UserEvent($user, $hostname)
        );

        $this->eventDispatcher->dispatch(
            UserEvent::ADMIN_SUBSCRIBED,
            new UserEvent($user, null)
        );

        return $this->messageService->addSuccess('Création de compte enregistrée. Confirmez votre compte par email. Vérifiez vos courriers indésirables.');
    }

    /**
     * @param User $user
     * @param array $data
     */
    public function updatePassword(User $user, array $data): void
    {
        $password_old = trim($data['password_old']);
        $password = trim($data['password']);

        if (password_verify($password_old, $user->getPassword())) {
                $user->setPassword($this->passwordService->encode($user, $password));
                $this->em->persist($user);
                $this->em->flush();

                $this->messageService->addSuccess('Mot de passe mis à jour');
        } else {
            $this->messageService->addError('Ce mot de passe est incorrect !');
        }
    }

    /**
     * @param int $id
     *
     * @return int|string
     */
    public function formatIncrement(int $id)
    {
        return str_pad($id + 1, 6, 0, STR_PAD_LEFT);
    }

    /**
     * REP + ANNEE + MOIS + JOUR + TOKEN GENERER.
     *
     * @return string
     */
    public function referenceFormat()
    {
        return 'DP'.substr(date('Y'), 2).date('md').uniqid();
    }
}
