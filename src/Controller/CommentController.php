<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller {

    public function commentform(Request $request, Post $post) {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment, [
            'action' => '/post/'.$post->getId().'/comment'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            $comment->setUser($this->getUser());
            $comment->setCreation_date(new \DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('post', [
                'id' => $post->getId()
            ]);
        }

        return $this->render('post/commentform.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
