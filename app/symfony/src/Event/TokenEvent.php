<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class TokenEvent extends Event
{
    const TOKEN_GENERATE = 'token.generate';
    const TEMPLATE_TOKEN_GENERATE = "email/request_password.html.twig";

    /**
     * @var User
     */
    protected $user;

    /**
     * UserEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
