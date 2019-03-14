<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * Used by the EasyAdmin Panel to hash correctly the password when an User is added
 */
class UserAdminController extends EasyAdminController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Allows applications to modify the entity associated with the item being
     * created while persisting it.
     *
     * @param object $entity
     */
    protected function persistEntity($entity)
    {
        $entity->setPassword($this->passwordEncoder->encodePassword($entity, $entity->getPassword()));
        parent::persistEntity($entity);
    }

    /**
     * Allows applications to modify the entity associated with the item being
     * edited before updating it.
     *
     * @param object $entity
     */
    protected function updateEntity($entity)
    {
        $entity->setPassword($this->passwordEncoder->encodePassword($entity, $entity->getPassword()));
        parent::updateEntity($entity);
    }
}