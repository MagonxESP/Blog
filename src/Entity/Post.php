<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;
/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $title;
    
    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $content;
    
    /**
     * @ORM\Column(type="datetime")
     */
    
    private $creationDate;
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post")
     */
    private $comments;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="posts", cascade={"persist"})
     * @ORM\JoinTable(name="posts_tags")
     */
    private $tags;
    
    public function __construct() {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->creationDate = new DateTime();
    }
    
    public function getTags() {
        return $this->tags;
    }

    public function addTag(Tag ...$tags) {
        foreach($tags as $tag) {
            if(!$this->tags->contains($tag)) {
                $this->tags->add($tag);
            }
        }
    }

    public function removeTag(Tag $tag) {
        $this->tags->removeElement($tag);
    }

    public function getComments() {
        return $this->comments;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreationDate(): DateTime {
        return $this->creationDate;
    }

    public function getAuthor(): User {
        return $this->author;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setCreationDate(DateTime $creationDate) {
        $this->creationDate = $creationDate;
    }

    public function setAuthor(User $author) {
        $this->author = $author;
    }
    
}
