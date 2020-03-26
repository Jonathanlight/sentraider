<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DateInfoTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     * @Serializer\Expose
     */
    private $updated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @Serializer\Expose
     */
    private $created;

    /**
     * @param \DateTime|null $updated
     */
    public function setUpdated(?\DateTime $updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime|null $creadted
     */
    public function setCreated(?\DateTime $creadted): void
    {
        $this->created = $creadted;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }
}