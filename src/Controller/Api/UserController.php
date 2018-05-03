<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 3/05/18
 * Time: 15:47
 */

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller {

    private function serialize(User $user) {
        return [
          'id' => $user->getId(),
          'username' => $user->getUsername(),
          'password' => $user->getPassword(),
          'rol' => $user->getRol(),
          'lastLogin' => $user->getLastlogin(),
          'isActive' => $user->getIsActive()
        ];
    }

    public function users() {
        $allusers = [];

        try {
            $users = $this->getDoctrine()
                            ->getRepository(User::class)
                            ->findAll();

            foreach($users as $user) {
                $allusers[] = $this->serialize($user);
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse($allusers);
    }
    /*
    public function getUser(string $username) {
        $array = [];

        try {
            $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->findBy([ 'username' => $username ]);

            foreach($users as $user) {
                $array[] = $this->serialize($user);
            }
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse($array);
    }*/

    public function newUser(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        try {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $rol = $request->request->get('rol', 'ROLE_USER');
            $isActive = $request->request->get('isActive', true);

            if($username == null && $password == null) {
                throw new \Exception("Invalid username and password");
            }

            $newuser = new User();
            $newuser->setUsername($username);
            $password = $passwordEncoder->encodePassword($newuser, $password);
            $newuser->setPassword($password);
            $newuser->setRol($rol);
            $newuser->setIsActive($isActive);
            $newuser->setLastlogin(new \DateTime());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newuser);
            $manager->flush();
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 204);
        }

        return new JsonResponse($this->serialize($newuser));
    }



}