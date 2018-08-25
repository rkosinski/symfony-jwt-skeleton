<?php declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \Serializable
{
    private $id;
    private $email;
    private $password;
    private $active;

    public function __construct(Email $email)
    {
        $this->email = (string) $email;
        $this->active = true;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getUsername() : string
    {
        return $this->email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function isAccountNonExpired() : bool
    {
        return true;
    }

    public function isAccountNonLocked() : bool
    {
        return true;
    }

    public function isCredentialsNonExpired() : bool
    {
        return true;
    }

    public function isEnabled() : bool
    {
        return $this->active;
    }

    public function getRoles() : array
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function serialize() : string
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->active,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->active,
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}