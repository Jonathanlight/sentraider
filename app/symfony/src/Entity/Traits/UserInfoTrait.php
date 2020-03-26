<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait UserInfoTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(checkMX=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Length(min=6)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordReset", type="string", length=255, nullable=true)
     */
    private $passwordReset;

    /**
     * @var string
     * @ORM\Column(length=14, nullable=true)
     * @Assert\Length(min="14", max="14")
     * @Assert\Type(type="digit")
     */
    protected $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordDispatch", type="string", length=255, nullable=true)
     */
    private $passwordDispatch;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="passwordResetDate", type="datetime", nullable=true)
     */
    private $passwordResetDate;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    private $prenom;

    /**
     * @var string
     *
     * @Assert\Length(
     *      max = 20,
     *      maxMessage = "Le numéro est limité"
     * )
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $types;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $hasValidatedCGU = false;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    private $reference;

    /**
     * @var int
     *
     * @ORM\Column(name="validated", type="integer", length=5, nullable=true)
     */
    private $validated;

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $genre;

    /**
     * @return string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return null|string
     */
    public function getGenre(): ?string
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return bool
     */
    public function getHasValidatedCGU(): bool
    {
        return $this->hasValidatedCGU;
    }

    /**
     * @param bool $hasValidatedCGU
     */
    public function setHasValidatedCGU(bool $hasValidatedCGU): void
    {
        $this->hasValidatedCGU = $hasValidatedCGU;
    }

    /**
     * @param \DateTime|null $passwordResetDate
     */
    public function setPasswordResetDate(?\DateTime $passwordResetDate): void
    {
        $this->passwordResetDate = $passwordResetDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getPasswordResetDate(): ?\DateTime
    {
        return $this->passwordResetDate;
    }

    /**
     * @param string $passwordReset
     */
    public function setPasswordReset($passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * Get passwordReset
     *
     * @return string
     */
    public function getPasswordReset()
    {
        return $this->passwordReset;
    }

    /**
     * @param $passwordDispatch
     */
    public function setPasswordDispatch($passwordDispatch): void
    {
        $this->passwordDispatch = $passwordDispatch;
    }

    /**
     * @return null|string
     */
    public function getPasswordDispatch(): ?string
    {
        return $this->passwordDispatch;
    }

    /**
     * @return null|string
     */
    public function getTypes(): ?string
    {
        return $this->types;
    }

    /**
     * @param null|string $types
     */
    public function setTypes(?string $types): void
    {
        $this->types = $types;
    }

    /**
     * @param integer $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }


    /**
     * @param integer $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param integer $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    /**
     * Get validated
     *
     * @return integer
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getSiret(): ?string
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     */
    public function setSiret(?string $siret): void
    {
        $this->siret = $siret;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {}
}