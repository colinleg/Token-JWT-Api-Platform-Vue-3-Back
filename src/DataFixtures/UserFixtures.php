<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
        
    }
    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setEmail('colin.legoedec@laposte.net')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
        ;

        $user->setPassword($this->hasher->hashPassword($user,'pass'));

        $manager->persist($user);

        $manager->flush();
    }
}
