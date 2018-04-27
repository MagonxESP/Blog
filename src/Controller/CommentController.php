<?php

namespace App\Controller;

//use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller {

    public function commentform(Request $request, Post $post) {
        // crear formulario y renderizarlo en la plantilla!!
        return $this->render('post/commentform.html.twig');
    }

}
