<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class UserUpdateEvent extends Event
{
    const ADMIN_CHECK_PROFIL_USER = 'admin.check.profil';
    const TEMPLATE_ADMIN_CHECK_PROFIL_USER = "email/admin/profil_update.html.twig";

    /**
     * @var User
     */
    protected $user;

    /**
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