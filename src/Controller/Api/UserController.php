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

    public function getUserByUserName(string $username) {
        try {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy([ 'username' => $username ]);
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse($this->serialize($user));
    }

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

    public function updateUser(Request $request, string $username, UserPasswordEncoderInterface $passwordEncoder) {
        // inicializamos con 204 por si al final del persist salta una excepcion el en catch devolvemos el 204
        $statusCode = 204;

        try {
            $user = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findOneBy([ 'username' => $username ]);

            if($user == null) {
                $statusCode = 404;
                throw new \Exception("User not found");
            }

            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $rol = $request->request->get('rol');
            $isActive = $request->request->get('isActive');

            if($username != null) {
                $user->setUsername($username);
            }

            if($password != null) {
                $password = $passwordEncoder->encodePassword($user, $password);
                $user->setPassword($password);
            }

            if($rol != null) {
                $user->setRol($rol);
            }

            if($isActive != null) {
                $user->setIsActive($isActive);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], $statusCode);
        }

        return new JsonResponse($this->serialize($user));
    }

    public function deleteUser(string $username) {
        try {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy([ 'username' => $username ]);

            if($user == null) {
                throw new \Exception("User not found");
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->remove($user);
            $manager->flush();
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 404);
        }

        return new JsonResponse([
            'status' => 'User '.$username.' deleted!'
        ]);
    }

}