<?php declare(strict_types=1);

namespace AppBundle\Repository\Doctrine;

use AppBundle\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class UserDoctrineRepository extends EntityRepository implements UserRepositoryInterface
{
}
