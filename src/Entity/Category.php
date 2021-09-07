<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'methods' => 'get',
            'openapi_context' => [
                'summary' => 'Récupérer toutes les catégories'
            ]
        ],
        'post' => [
            'methods' => 'post',
            'openapi_context' => [
                'summary' => 'Créer une catégorie'
            ]
        ]
    ],
    itemOperations: [
        'get' => [
            'methods' => 'get',
            'openapi_context' => [
                'summary' => 'Récupérer une catégorie'
            ]
            ],
        'put' => [
            'methods' => 'put',
            'openapi_context' => [
                'summary' => 'Remplacer une catégorie'
            ]
            ],
        'delete' => [
            'methods' => 'delete',
            'openapi_context' => [
                'summary' => 'Supprimer une catégorie'
            ]
            ],
        'patch' => ['methods' => 'patch']
    ]
)]
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_subCategory;

    /**
     * @ORM\OneToMany(targetEntity=SubCategory::class, mappedBy="category", orphanRemoval=true)
     */
    private $subCategories;

    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNbSubCategory(): ?int
    {
        return $this->nb_subCategory;
    }

    public function setNbSubCategory(int $nb_subCategory): self
    {
        $this->nb_subCategory = $nb_subCategory;

        return $this;
    }

    /**
     * @return Collection|SubCategory[]
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(SubCategory $subCategory): self
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories[] = $subCategory;
            $subCategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): self
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getCategory() === $this) {
                $subCategory->setCategory(null);
            }
        }

        return $this;
    }
}
