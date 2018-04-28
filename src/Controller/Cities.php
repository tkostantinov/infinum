<?php

namespace Infinum\Controller;

use Infinum\Framework\Controller;

class Cities extends Controller
{
    public function getAction()
    {
        if(isset($_GET['orderBy']) && $_GET['orderBy'] === "popularity")
            $cities = $this->getDiContainer()->cityRepository->getCitiesByPopularity();
        else {
            $cities = $this->getDiContainer()->cityRepository->getCities();
        }


        header('Content-Type: application/json');
        echo json_encode($cities);
    }

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

        $city = json_decode(file_get_contents('php://input'));

        $coordinates = $this->getDiContainer()->geoLocation->getCoordinates($city->name);

        $this->getDiContainer()->cityRepository->addCity($user->id, $city->name, $city->description, $coordinates->lat, $coordinates->lng);

        header('Content-Type: application/json');
        echo json_encode("Saved!");
    }
}
