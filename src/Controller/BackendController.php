<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 13/03/18
 * Time: 15:51
 */

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackendController extends Controller {

    public function index() {
        return $this->render('dashboard/dashboard.html.twig');
    }

    public function posts() {
        $posts = $this->getDoctrine()
                    ->getManager()
                    ->getRepository(Post::class)
                    ->findBy([ 'author' => $this->getUser() ]);

        return $this->render('dashboard/posts.html.twig', [
            'numPosts' => count($posts),
            'posts' => $posts
        ]);
    }

    public function account() {
        // renderizar formulario aqui

        return $this->render('dashboard/account.html.twig', [
            'user' => $this->getUser(),
            'changePasswordError' => null
        ]);
    }

    public function users() {
        $users = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findBy([ 'rol' => 'ROLE_USER' ]);

        return $this->render('dashboard/users.html.twig', [
            'numUsers' => sizeof($users),
            'users' => $users
        ]);
    }

}