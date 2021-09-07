<?php
    
    namespace App\DataTransformer;

use App\Dto\SubCategoryInput;
use App\Entity\SubCategory;
use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Repository\CategoryRepository;

final class SubCategoryInputDataTransformer implements DataTransformerInterface{

    public function __construct(
        private CategoryRepository $categoryRepository,
        
    )
    {}

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if($data instanceof SubCategoryInput){
            return false;
        }

        return true;
    }

    /**
     * @param SubCategoryInput $object 
     * @param SubCategory $to
     * @param array $context : operationType,name, ressource_class, input, output, request_uri ... 
     */
    public function transform($object, string $to, array $context = []) : SubCategory
    {
        
        $subCategory = (new SubCategory())
            ->setNom($object->getNom())
            ->setNbPosts(0);
        ;

        $category = $this->categoryRepository->findOneByName($object->getCategory());
        $subCategory->setCategory($category);
        // dd($subCategory);


        return $subCategory;

    }

}