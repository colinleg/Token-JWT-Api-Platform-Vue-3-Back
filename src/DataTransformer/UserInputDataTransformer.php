<?php 

    namespace App\DataTransformer;

use App\Dto\UserInput;
use App\Entity\User;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

final class UserInputDataTransformer implements DataTransformerInterface{

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if($data instanceof User){
            return false;
        }

        return true;
    }

    /**
     * @param UserInput $object 
     * @param User $to
     * @param array $context : operationType,name, ressource_class, input, output, request_uri ... 
     */
    public function transform($object, string $to, array $context = []) : User
    {
        $user = (new User())
            ->setNom($object->getNom())
            ->setPrenom($object->getPrenom())
            ->setEmail($object->getEmail())
            ->setPassword($object->getPassword())
        ;

        $serverKey = 'v5b4d68r4f5dv';
        $adminKey = $object->getAdminKey();

        if ($adminKey === $serverKey){
            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        }
        else {
            $user->setRoles(['ROLE_USER']);
        }   

        // dd($user);
        return $user;
    }
}