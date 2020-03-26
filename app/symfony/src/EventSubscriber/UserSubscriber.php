<?php

namespace App\EventSubscriber;

use App\Event\UserEvent;
use App\Manager\UserManager;
use App\Services\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailerService
     */
    protected $mailer;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @param MailerService $mailerService
     * @param UserManager $userManager
     */
    public function __construct(
        MailerService $mailerService,
        UserManager $userManager
    ) {
        $this->mailer = $mailerService;
        $this->userManager = $userManager;
    }

    /**
     * @param UserEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onConfirm(UserEvent $event): void
    {
        $user = $event->getUser();
        $parameters = [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
        ];

        $this->mailer->send(
            '📟 DEVSPROF | Compte Validé',
            [$_ENV['MAIL_USER'] => 'DEVSPROF'],
            [$user->getEmail()],
            UserEvent::TEMPLATE_CONFIRMED,
            $parameters
        );
    }

    /**
     * @param UserEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onConfirmAdmin(UserEvent $event): void
    {
        $user = $event->getUser();
        $parameters = [
            'nom'       => $user->getNom(),
            'prenom'    => $user->getPrenom(),
            'role'      => $user->getRole(),
            'email'     => $user->getEmail(),
            'address'   => $user->getAddress(),
        ];

        $this->mailer->send(
            '📟 DEVSPROF | Confirmation de Compte',
            [$_ENV['MAIL_USER'] => 'DEVSPROF'],
            [ $_ENV['MAIL_ADMIN']],
            UserEvent::TEMPLATE_ADMIN_CONFIRMED,
            $parameters
        );
    }

    /**
     * @param UserEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onSubscribe(UserEvent $event): void
    {
        $user = $event->getUser();
        $parameters = [
            'email'         => $user->getEmail(),
            'nom'           => $user->getNom(),
            'prenom'        => $user->getPrenom(),
            'reference'     => $user->getReference(),
            'path'          => $event->getHost().'/activation/'.$user->getReference()
        ];

        $this->mailer->send(
            '📟 DEVSPROF | Inscription',
            [$_ENV['MAIL_USER'] => 'DEVSPROF'],
            [$user->getEmail()],
            UserEvent::TEMPLATE_SUBSCRIBED,
            $parameters
        );
    }

    /**
     * @param UserEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onSubscribeAdmin(UserEvent $event): void
    {
        $user = $event->getUser();
        $parameters = [
            'nom'       => $user->getNom(),
            'prenom'    => $user->getPrenom(),
            'role'      => $user->getRole(),
            'email'     => $user->getEmail(),
            'address'   => $user->getAddress(),
        ];

        $this->mailer->send(
            '📟 DEVSPROF | Nouveau Membre',
            [$_ENV['MAIL_USER'] => 'DEVSPROF'],
            [$_ENV['MAIL_ADMIN']],
            UserEvent::TEMPLATE_ADMIN_SUBSCRIBED,
            $parameters
        );
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            UserEvent::USER_CONFIRMED => 'onConfirm',
            UserEvent::USER_SUBSCRIBED => 'onSubscribe',
            UserEvent::ADMIN_CONFIRMED => 'onConfirmAdmin',
            UserEvent::ADMIN_SUBSCRIBED => 'onSubscribeAdmin',
        ];
    }
}