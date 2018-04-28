<?php

namespace Infinum\Repository;

use PDO;

class City
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCities()
    {
        $sql = 'SELECT * FROM city ORDER BY id';

        return $this->db->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public function addCity($userId, $name, $description, $lat, $lng)
    {
        $sql = "INSERT INTO city
                  (
                      user_id,
                      name,
                      description,
                      lat,
                      lng
                  )
                  VALUES
                  (
                    :user_id,
                    :name,
                    :description,
                    :lat,
                    :lng
                )
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':lat', $lat);
        $stmt->bindParam(':lng', $lng);

        $stmt->execute();
    }
}
