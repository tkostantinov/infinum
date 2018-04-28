<?php

namespace Infinum\Controller;

use Infinum\Framework\Controller;

class Favorites extends Controller
{
    public function postAction()
    {
        $favorite = json_decode(stream_get_contents(STDIN));

        $user = $this->getDiContainer()->userRepository->getUserByToken($_GET['token']);

        $result = $this->getDiContainer()->userRepository->addFavorite($user->id, $favorite->city_id);

        header('Content-Type: application/json');
        echo json_encode("Added to favorites");
    }

    public function deleteAction()
    {
        $id = $_GET['id'];

        $user = $this->getDiContainer()->userRepository->getUserByToken($_GET['token']);

        $result = $this->getDiContainer()->userRepository->deleteFavorite($user->id, $id);

        header('Content-Type: application/json');
        echo json_encode("DELETED");
    }
}
