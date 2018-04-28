<?php

namespace Infinum\Repository;

use PDO;

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE token = :token");
        $stmt->bindParam(':token', $token);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addToFavorites($userId, $cityId)
    {
        $sql = "INSERT INTO user_favorite_city
                  (
                      user_id,
                      city_id
                  )
                  VALUES
                  (
                    :user_id,
                    :city_id
                )
            ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':city_id', $cityId);

        $stmt->execute();
    }

    public function removeFromFavorites($userId, $cityId)
    {
        $sql = "DELETE FROM user_favorite_city
                  WHERE
                       user_id = :user_id AND city_id = :city_id
                   LIMIT 1
                ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':city_id', $cityId);

        $stmt->execute();
    }
}