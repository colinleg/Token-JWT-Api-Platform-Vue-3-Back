<?php

    namespace App\Eventlistener;

use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

# Cette classe est appelée depuis config/service.yaml
class AuthenticationSuccessListener{

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
  
        if (!$user instanceof UserInterface) {
            return;
        }

        # On ajoute ici les datas publiques que l'on veut renvoyer dans la réponse,
        # en même temps que le token JWT
        $data['data'] = array(
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom()
        );

        $event->setData($data);
    }

}

