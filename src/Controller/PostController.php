<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller {

    public function post($id) {
        $post = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->find($id);

        return $this->render('post.html.twig', [
            'post' => $post
        ]);
    }

    public function createPost(Request $request) {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post->setAuthor($this->getUser());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('dashboard_posts');
        }

        return $this->render('dashboard/posteditor.html.twig', [
           'form' => $form->createView()
        ]);
    }

    public function editPost(Request $request, int $id) {
        $post = $this->getDoctrine()
                    ->getRepository(Post::class)
                    ->findOneBy([ 'id' => $id ]);

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post->setAuthor($this->getUser());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('dashboard_posts');
        }

        return $this->render('dashboard/posteditor_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function deletePost(Request $request) {
        $id = $request->get('id');
        $errorMessage = null;
        $isRemoved = false;

        try {
            $post = $this->getDoctrine()
                ->getRepository(Post::class)
                ->findOneBy([ 'id' => $id ]);

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($post);
            $manager->flush();

            $isRemoved = true;
        } catch(\Exception $e) {
            $isRemoved = false;
            $errorMessage = $e->getMessage();
        }

        return new JsonResponse([
            'removed' => $isRemoved,
            'postid' => $id,
            'error' => $errorMessage
        ]);
    }
}
