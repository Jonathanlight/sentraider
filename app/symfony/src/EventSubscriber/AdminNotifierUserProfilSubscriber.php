<?php

namespace App\EventSubscriber;

use App\Event\AdminNotifierUserProfilEvent;
use App\Services\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminNotifierUserProfilSubscriber implements EventSubscriberInterface
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
     * @param AdminNotifierUserProfilEvent $event
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onSendingAdmin(AdminNotifierUserProfilEvent $event): void
    {
        $user = $event->getUser();
        $parameters = [
            'nom'           => $user->getNom(),
            'prenom'        => $user->getPrenom(),
        ];

        $this->mailer->send(
            '📟 DEVSPROF | Bonjour ' . $user->getPrenom(),
            [$_ENV['MAIL_USER'] => 'DEVSPROF'],
            [$user->getEmail()],
            AdminNotifierUserProfilEvent::TEMPLATE_ADMIN_SENDING_NOTIFIER,
            $parameters
        );
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AdminNotifierUserProfilEvent::class => [
                ['onSendingAdmin', 1]
            ]
        ];
    }
}