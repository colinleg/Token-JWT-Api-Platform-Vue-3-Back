<?php
    namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class SubCategoriesByCatDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface{

    public function __construct(
        private RequestStack $requestStack,
        private SubCategoryRepository $subCategoryRepository,
        private CategoryRepository $categoryRepository
    )
    {}

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        if($operationName == 'get_SubCategory_by_Categorie'){
            return true;
        }
        else {
            return false;
        }   
        
    }

    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {
        # une string
        $category_string = $this->requestStack->getCurrentRequest()->query->get('categorie');

        $allSubCategories = $this->subCategoryRepository->findAll();
        $data = array();
        
        foreach($allSubCategories as $cat){

            if($cat->getCategory()->getNom() === $category_string){
                array_push($data, $cat->getNom());
            }

        }

        # un tableau de strings, qui sont des noms de sous-catégories
        return $data;
    }

    
}