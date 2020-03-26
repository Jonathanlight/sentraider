<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{
    const USER_CONFIRMED = 'user.confirmed';
    const USER_SUBSCRIBED = 'user.subscribed';
    const ADMIN_CONFIRMED = 'admin.confirmed';
    const ADMIN_SUBSCRIBED = 'admin.subscribed';
    const TEMPLATE_CONFIRMED = "email/confirmed.html.twig";
    const TEMPLATE_SUBSCRIBED = "email/subscribe.html.twig";
    const TEMPLATE_ADMIN_CONFIRMED = "email/admin/confirmed.html.twig";
    const TEMPLATE_ADMIN_SUBSCRIBED = "email/admin/subscribe.html.twig";

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $host;

    /**
     * UserEvent constructor.
     * @param User $user
     * @param null|string $host
     */
    public function __construct(User $user, ?string $host)
    {
        $this->user = $user;
        $this->host = $host;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
}