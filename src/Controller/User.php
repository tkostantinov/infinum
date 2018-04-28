<?php

namespace Infinum\Controller;

use Infinum\Framework\Controller;

class User extends Controller
{

    public function loginAction()
    {
        $credentials = json_decode(stream_get_contents(php::stdin));

        try {
            $user = $this->getDiContainer()->authorization->login($credentials->email, $credentials->password);
        } catch(Exception $e)
        {
            return json_encode("No such user");
        }

        header('Content-Type: application/json');
        return json_encode($user);
    }

    public function registerAction()
    {
        $user = json_decode(stream_get_contents(php::stdin));

        die($user);

        $token = $this->getDiContainer()->tokenGenerator->generate();

        $user = $this->getDiContainer()->userRepository()->addUser($user->email, $user->password, $token);
        header('Content-Type: application/json');
        return json_encode($user);
    }
}