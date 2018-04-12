<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", mappedBy="tags")
     */
    private $posts;
    
    public function __construct() {
        $this->posts = new ArrayCollection();
    }
    
    public function getPosts() {
        return $this->posts;
    }

    public function addPost(Post $post) {
        $this->posts->add($post);
    }

    public function removePost(Post $post) {
        $this->posts->removeElement($post);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function __toString() {
        return $this->name;
    }

}
