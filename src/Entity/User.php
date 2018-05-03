<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     *
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $username;
    
    /**
     *
     * @ORM\Column(type="string", length=60)
     */
    private $password;
    
    /**
     *
     * @ORM\Column(type="string")
     */
    private $rol = "ROLE_USER";
    
    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="author")
     */
    private $posts;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;
    
    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = true;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastlogin;
    
    public function __construct() {
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
    
    public function getComments() {
        return $this->comments;
    }
    
    public function getPosts() {
        return $this->posts;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }
        
    public function getRol() {
        return $this->rol;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function setUsername(string $username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setRol(string $rol) {
        $this->rol = $rol;
    }
    
    public function getIsActive() {
        return $this->isActive;
    }

    public function getLastlogin() {
        return $this->lastlogin;
    }

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    public function setLastlogin(DateTime $lastlogin) {
        $this->lastlogin = $lastlogin;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles() {
        return [$this->rol];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt() {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {
        // TODO: Implement eraseCredentials() method.
    }

}
