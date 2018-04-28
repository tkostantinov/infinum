<?php

namespace Infinum\Controller;

use Infinum\Framework\Controller;

class User extends Controller
{

    public function loginAction()
    {
        $credentials = json_decode(file_get_contents('php://input'));

        try {
            $user = $this->getDiContainer()->userRepository->auth($credentials->email, $credentials->password);
        } catch (Exception $e) {
            return json_encode("No such user");
        }

        header('Content-Type: application/json');

        echo json_encode($user);
    }

    public function registerAction()
    {
        $user = json_decode(file_get_contents('php://input'));

        $token = $this->getDiContainer()->tokenGenerator->generate();

        $user = $this->getDiContainer()->userRepository->addUser($user->email, $user->password, $token);

        header('Content-Type: application/json');
        echo json_encode($user);
    }
}