<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class SecurityController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods:["POST"])]
    public function login(Request $req)
    {
        $user = $this->getUser();
        dd($user);
        # ça part dans JWT
        return $this->json([
            'username' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);
    }

}
