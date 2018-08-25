<?php declare(strict_types=1);

namespace App\Repository\Doctrine;

use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
}