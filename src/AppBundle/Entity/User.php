<?php declare(strict_types=1);

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    protected $id;

    public function getId() : int
    {
        return $this->id;
    }
}
