<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;
    
    public function getId() {
        return $this->id;
    }

    public function getContent() {
        return $this->content;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getPost(): Post {
        return $this->post;
    }

    public function getCreation_date() {
        return $this->creation_date;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setContent(string $content) {
        $this->content = strip_tags(htmlspecialchars($content));
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

    public function setPost(Post $post) {
        $this->post = $post;
    }

    public function setCreation_date(\DateTime $creation_date) {
        $this->creation_date = $creation_date;
    }

}
