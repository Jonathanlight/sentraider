<?php

namespace App\EventSubscriber;

use App\Event\UserUpdateEvent;
use App\Services\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserUpdateSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailerService
     */
    protected $mailer;

    /**
     * @param MailerService $mailerService
     */
    public function __construct(
        MailerService $mailerService
    ) {
        $this->mailer = $mailerService;
    }

    /**
     * @param UserUpdateEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onSendingAdmin(UserUpdateEvent $event): void
    {
        $user = $event->getUser();
        $parameters = [
            'nom'           => $user->getNom(),
            'prenom'        => $user->getPrenom(),
            'email'         => $user->getEmail(),
            'role'          => $user->getRole(),
        ];

        $this->mailer->send(
            '📟 DEVSPROF | PROFIL MODIFIER ' . $user->getPrenom() . ' ' . $user->getNom(),
            [$_ENV['MAIL_USER'] => 'DEVSPROF'],
            [$_ENV['MAIL_ADMIN']],
            UserUpdateEvent::TEMPLATE_ADMIN_CHECK_PROFIL_USER,
            $parameters
        );
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            UserUpdateEvent::class => [
                ['onSendingAdmin', 1]
            ]
        ];
    }
}