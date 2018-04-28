<?php

namespace Infinum\Controller;

use Infinum\Framework\Controller;

class Favorites extends Controller
{
    public function postAction()
    {
        $token = $_GET['token'];

        if(!$token)
        {
            header('Content-Type: application/json');
            echo json_encode("Invalid token");
            exit;
        }

        $user = $this->getDiContainer()->userRepository->getUserByToken($token);

        if(!$user)
        {
            header('Content-Type: application/json');
            echo json_encode("Invalid token");
            exit;
        }


        $favorite = json_decode(file_get_contents('php://input'));

        $result = $this->getDiContainer()->userRepository->addToFavorites($user->id, $favorite->city_id);

        header('Content-Type: application/json');
        echo json_encode("Added to favorites");
    }

    public function deleteAction($cityId)
    {
        $token = $_GET['token'];

        if(!$token)
        {
            header('Content-Type: application/json');
            echo json_encode("Invalid token");
            exit;
        }

        $user = $this->getDiContainer()->userRepository->getUserByToken($token);

        if(!$user)
        {
            header('Content-Type: application/json');
            echo json_encode("Invalid token");
            exit;
        }

        $user = $this->getDiContainer()->userRepository->getUserByToken($_GET['token']);

        $result = $this->getDiContainer()->userRepository->removeFromFavorites($user->id, $cityId);

        header('Content-Type: application/json');
        echo json_encode("DELETED");
    }
}
