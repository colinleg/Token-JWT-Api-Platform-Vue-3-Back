<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\SubCategoryInput;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubCategoryRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get' => [
            'method' => 'get'
        ],
        'get_SubCategory_by_Categorie' => [
            'method' => 'get',
            'path' => 'sub_categories_of',
            'pagination_enabled' => false,
            'openapi_context' => [
                'summary' => 'Récupère la liste des sous-catégories appartenant à une catégorie',
                'parameters' => [

                    [
                    'in' => 'query',
                    'name' => 'categorie',
                    'type' => 'string',
                    'required' => true,
                    'description' => 'La catégorie à laquelle appartiennent les sous-catégories qui seront retournées'
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Une liste de nom de sous-catégories',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'hydra:member' => [
                                            'type' => 'array',
                                            'items' => [
                                                'type' => 'string',
                                                'example' => 'sousCategorie1',
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ],
        'add_subCategory' => [
            'method' => 'post',
            'input' => SubCategoryInput::class,
            // 'write' => false,
            'validate' => false,
            'openapi_context' => [
                'summary' => 'Ajouter une sous-catégorie',
                'description' => 'Ajout depuis la liste des catégories, on connaît donc le nom de la catégorie parente',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'nom' => [
                                        'type' => 'string',
                                        'example' => 'sousCategory1'
                                    ],
                                    'category' => [
                                        'type' => 'string',
                                        'example' => 'category1'
                                    ]
                                ]   
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
)]
class SubCategory
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
    private $nbPosts;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subCategories")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="subCategory", orphanRemoval=true)
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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

    public function getNbPosts(): ?int
    {
        return $this->nbPosts;
    }

    public function setNbPosts(int $nbPosts): self
    {
        $this->nbPosts = $nbPosts;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setSubCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getSubCategory() === $this) {
                $post->setSubCategory(null);
            }
        }

        return $this;
    }
}
