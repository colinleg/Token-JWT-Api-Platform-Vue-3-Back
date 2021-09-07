<?php

    namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\SubCategory;
use Doctrine\ORM\EntityManagerInterface;

final class SubCategoryDataPersister implements ContextAwareDataPersisterInterface{

    public function __construct(
        private EntityManagerInterface $em,

    )
    {}

    public function supports($data, array $context = []): bool
    {
        return $data instanceof SubCategory;
    }

    public function persist($data, array $context = [])
    {
        // dd($data, $context);
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data, array $context = [])
    {
        
    }
}