<?php

namespace Infinum\Service;

class Authorization
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function autenticate($email, $password)
    {
        if($user = $this->db->findUser($email, $password))
        {

            $response = [
                "Status" => "OK",
                "token" => $user->token
            ];

            header(json_encode($response), null, 401);
        }

        else
        {
            header(json_encode("Invalid data"), null, 401);
        }
    }
}