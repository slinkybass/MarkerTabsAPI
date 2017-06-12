<?php

namespace MarkerTabsBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    private $entity = 'MarkerTabsBundle:User';

    public function getOne($id)
    {
        return $this->getEntityManager()->createQueryBuilder()
        ->select(array('obj'))
        ->from($this->entity, 'obj')
        ->where($this->getEntityManager()->createQueryBuilder()->expr()->eq('obj.id', ':obj_id'))
        ->setParameter('obj_id', $id)
        ->getQuery()->getOneOrNullResult();
    }

    public function getUserIDLogged($auth, $helpers)
    {
        if ($auth) {
            list($type, $token) = explode(' ', $auth);
            if ($type === 'Bearer' && $helpers->authCheck($token)) {
                $identity = $helpers->authCheck($token, true);
                return (isset($identity->sub)) ? $identity->sub : false;
            }
        }
        return false;
    }
}
