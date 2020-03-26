<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class AdminNotifierUserProfilEvent extends Event
{
    const NOTIFIER_USER_PROFIL = 'notifier.user.profil';
    const TEMPLATE_ADMIN_SENDING_NOTIFIER = "email/admin/notifier_user_profil.html.twig";

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