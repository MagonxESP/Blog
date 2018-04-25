<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function index() {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    public function login(Request $request, AuthenticationUtils $authUtils) {
        $error = $authUtils->getLastAuthenticationError();
        $lastUserName = $authUtils->getLastUsername();

        if($this->getUser()) {
            $usr = $this->getUser();
            $usr->setLastLogin(new \DateTime());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usr);
            $manager->flush();
        }

        return $this->render('user/login.html.twig', [
            'error' => $error,
            'lastUserName' => $lastUserName
        ]);
    }

    public function logout() {
        $this->redirectToRoute('logout');
    }

    public function signup(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $usr = new User();

        $form = $this->createForm(RegisterType::class, $usr);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($usr, $usr->getPassword());
            $usr->setPassword($password);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usr);
            $manager->flush();

            return $this->redirectToRoute('login');
        }


        return $this->render('user/registrarse.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder, int $id) {
        $status = false;
        $usr = $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findOneBy([ 'id' => $id ]);

        $form = $this->createForm(EditUserType::class, $usr);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($usr, $usr->getPassword());
            $usr->setPassword($password);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($usr);
            $manager->flush();
            $status = true;
        }

        return $this->render('dashboard/edituser.html.twig', [
           'form' => $form->createView(),
           'status' => $status
        ]);
    }

    public function rename(Request $request) {
        $user = $this->getUser();
        $newUserName = $request->get('newusername');

        if($user->getUsername() != $newUserName) {
            $user->setUsername($newUserName);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
        }

        return $this->redirectToRoute('dashboard_account');
    }

    public function changePassword(Request $request) {
        $passwordEncoder = new PasswordEncoder();
        $user = $this->getUser();
        $oldPassword = $passwordEncoder->encodePassword($user, $request->get('currentpassword'));
        $newpassword = $request->get('newpassword');
        $repeatedPassword = $request->get('repatnewpassword');

        if($oldPassword === $user->getPassword()) {
            if($newpassword === $repeatedPassword) {
                $password = $passwordEncoder->encodePassword($user, $newpassword);
                $user->setPassword($password);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
            }
        }

        return $this->redirectToRoute('dashboard_account');
    }

    /**
     * Comprueba si ese nombre de usuario esta en uso
     * (se ejecutara mediante una peticion de ajax)
     * @param Request $request
     * @return JsonResponse
     */
    public function existsUsername(Request $request) {
        $isUsed = false;
        $username = $request->get('username');
        $user = $this->getDoctrine()
                        ->getManager()
                        ->getRepository(User::class)
                        ->findOneBy(['username' => $username]);

        if(isset($user) && !empty($user)) {
            $isUsed = true;
        }

        return new JsonResponse([
            'isused' => $isUsed
        ]);
    }

    /**
     * Elimina un usuario por su id
     * (se ejecutara mediante ajax)
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteUser(Request $request) {
        $userId = $request->get('userid');
        $errorMessage = "";

        try {
            $manager = $this->getDoctrine()->getManager();
            $usr = $manager->getRepository(User::class)
                            ->findOneBy([ 'id' => $userId ]);
            $manager->remove($usr);
            $manager->flush();
            $done = true;
        } catch(\Exception $e) {
            $errorMessage = $e->getMessage();
            $done = false;
        }

        return new JsonResponse([
            'error' => $errorMessage,
            'status' => $done
        ]);
    }

}
