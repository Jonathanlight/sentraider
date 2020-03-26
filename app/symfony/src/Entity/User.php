<?php

namespace App\Entity;

use App\Entity\Traits\AdminInfoTrait;
use App\Entity\Traits\DateInfoTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\GeolocableTrait;
use App\Entity\Traits\UserInfoTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Entity(repositoryClass="App\Repository\UserRepository")
*/
class User implements UserInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    const PROFIL_VALIDATED = 1;
    const PROFIL_NON_VALIDATED = 0;
    const PROFIL_NULL = 2;

    const STATUS_WOMAN = 'F';
    const STATUS_MAN = 'H';

    const KEY_PASSWORD_DISPATCH = "Bonjour2019*";

    const ACCOUNT_DELETE = "DELETE";

    use UserInfoTrait;
    use DateInfoTrait;
    use GeolocableTrait;
    use DeletedTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Loads the user for the given username.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        // TODO: Implement loadUserByUsername() method.
    }

    /**
     * Refreshes the user for the account interface.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }

}
