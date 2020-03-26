<?php

namespace App\Services;

class MailerService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * MailerService constructor.
     *
     * @param \Swift_Mailer       $mailer
     * @param \Twig_Environment   $twig
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param string $subject
     * @param array $mailFrom
     * @param array $mailTo
     * @param string $template
     * @param array $parameters
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function send(string $subject, array $mailFrom, array $mailTo, string $template, array $parameters): void
    {

        $to = $mailTo ?? [];
        $from = $mailFrom ?? [];

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($this->twig->render($template, $parameters), 'text/html');

        $this->mailer->send($message);
    }

}