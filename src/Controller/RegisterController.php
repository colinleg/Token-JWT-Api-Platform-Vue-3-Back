<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private KernelInterface $kernelInterface,
        private UserPasswordHasherInterface $hasher
    )
    {}

    /**
     * UserInput -> UnserInputDataTransformer -> Register Controller
     * Persistance basique via Doctrine ORM
     *
     * @param Request $request envoyée par le UserInputDataTransformer
     * @return void
     */
    public function __invoke(Request $request)
    {
        $user = $request->get('data');

        # encodage du password
        $plainPass = $user->getPassword();
        $user->setPassword($this->hasher->hashPassword($user,$plainPass));

        $this->em->persist($user);
        $this->em->flush();

    }
}
