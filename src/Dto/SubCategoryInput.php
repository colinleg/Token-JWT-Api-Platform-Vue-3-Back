<?php

    namespace App\Dto;

final class SubCategoryInput{

    public $nom;

    public $category;

    public function getNom(){
        return $this->nom;
    }

    public function getCategory(){
        return $this->category;
    }


}