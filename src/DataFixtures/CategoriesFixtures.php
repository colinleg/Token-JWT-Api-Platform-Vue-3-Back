<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 11 ;$i++){

            $category = (new Category())
            ->setNom('Cat_'.$i)
            ->setNbSubCategory(0)
            ;

            $manager->persist($category);

        }
        

        $manager->flush();
    }
}
