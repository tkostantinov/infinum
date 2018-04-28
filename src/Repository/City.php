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

    public function getCitiesByPopularity()
    {
        $sql = 'SELECT * FROM city c LEFT JOIN (
                  SELECT COUNT(user_id) as popularity, city_id FROM user_favorite_city GROUP BY city_id
                  ) as p
                  ON c.id = p.city_id
                ORDER BY
                p.popularity
              ';

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
