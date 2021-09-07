<?php 

    namespace App\Dto;

final class UserInput{

    public $nom;

    public $prenom;

    public $email;

    public $plainPass;

    public $Adminkey;

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->plainPass;
    }

    public function getAdminKey(){
        return $this->Adminkey;
    }

}