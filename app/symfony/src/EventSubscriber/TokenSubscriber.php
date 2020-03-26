<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Event\TokenEvent;
use App\Services\MailerService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailerService
     */
    protected $mailer;

    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @param MailerService $mailerService
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        MailerService $mailerService,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->mailer = $mailerService;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param TokenEvent $tokenEvent
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function onTokenGenerate(TokenEvent $event): void
    {
        $user = $event->getUser();
        $parameters = [
            'prenom' => $user->getPrenom(),
            'link' => $this->urlGenerator->generate('user_reset', [
                'reference' => $user->getReference()
            ], UrlGeneratorInterface::ABSOLUTE_URL)
        ];

        $this->mailer->send(
            '🔑 DEVSPROF | Demande de mot de passe oublié',
            [$_ENV['MAIL_USER'] => 'DEVSPROF'],
            [$user->getEmail()],
            TokenEvent::TEMPLATE_TOKEN_GENERATE,
            $parameters
        );
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            TokenEvent::class => [
                ['onTokenGenerate', 1]
            ]
        ];
    }
}
