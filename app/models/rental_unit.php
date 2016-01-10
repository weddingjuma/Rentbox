<?php

class RentalUnit extends BaseModel {

    public $id, $description_title, $description, $address, $advertised_rent, $landlord, $area, $available;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validation_rules = array(
            'required' => array(array('address'), array('area')),
            'numeric' => array(array('area'), array('advertised_rent')),
            'lengthBetween' => array(array('address', 10, 255)),
            'lengthMax' => array(array('description_title', 255), array('description', 1000))
        );
    }

    public static function searchAll() {
        $query = DB::connection()->prepare(
                'SELECT * FROM rental_unit
                LEFT JOIN
                (SELECT lease1.end_date, lease1.rental_unit
                FROM lease AS lease1
                LEFT OUTER JOIN lease AS lease2
                ON lease1.rental_unit = lease2.rental_unit AND lease1.end_date < lease2.end_date
                WHERE lease2.rental_unit IS NULL
                ORDER BY lease1.end_date ASC) 
                AS lease
                ON rental_unit.id = lease.rental_unit
                ORDER BY lease.end_date ASC NULLS FIRST;');
        $query->execute();
        $rows = $query->fetchAll();
        $searchResults = array();

        foreach ($rows as $row) {
            $searchResults[] = new RentalUnit(array(
                'id' => $row['id'],
                'description_title' => $row['description_title'],
                'description' => $row['description'],
                'address' => $row['address'],
                'advertised_rent' => $row['advertised_rent'],
                'landlord' => $row['landlord'],
                'available' => $row['end_date']
            ));
        }
        return $searchResults;
    }

    public static function findPortfolio($userId) {
        $query = DB::connection()->prepare(
                'SELECT * FROM rental_unit
                LEFT JOIN
                (SELECT lease1.end_date, lease1.rental_unit
                FROM lease AS lease1
                LEFT OUTER JOIN lease AS lease2
                ON lease1.rental_unit = lease2.rental_unit AND lease1.end_date < lease2.end_date
                WHERE lease2.rental_unit IS NULL
                ORDER BY lease1.end_date ASC) 
                AS lease
                ON rental_unit.id = lease.rental_unit
                WHERE rental_unit.landlord = :userId
                ORDER BY lease.end_date ASC NULLS FIRST;');
        $query->execute(array('userId' => $userId));
        $rows = $query->fetchAll();
        $portfolio = array();
        foreach ($rows as $row) {
            $portfolio[] = new RentalUnit(array(
                'id' => $row['id'],
                'title' => $row['description_title'],
                'description' => $row['description'],
                'address' => $row['address'],
                'advertised_rent' => $row['advertised_rent'],
                'landlord' => $row['landlord'],
                'area' => $row['area'],
                'available' => $row['end_date']
            ));
        }
        return $portfolio;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM rental_unit WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $rental_unit = new RentalUnit(array(
                'id' => $row['id'],
                'description_title' => $row['description_title'],
                'description' => $row['description'],
                'address' => $row['address'],
                'advertised_rent' => $row['advertised_rent'],
                'area' => $row['area'],
                'landlord' => $row['landlord']
            ));
            return $rental_unit;
        }
        return null;
    }

    public function save($user_id) {
        $query = DB::connection()->prepare('INSERT INTO rental_unit '
                . '(address, area, landlord) '
                . 'VALUES (:address, :area, :landlord) '
                . 'RETURNING id');
        $query->execute(array(
            'address' => $this->address,
            'area' => $this->area,
            'landlord' => $user_id
        ));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function updateUnit() {
        $query = DB::connection()->prepare('UPDATE rental_unit '
                . 'SET '
                . 'description_title = :description_title, '
                . 'description = :description, '
                . 'address = :address, '
                . 'advertised_rent = :advertised_rent, '
                . 'area = :area '
                . 'WHERE id = :id');
        $query->execute(array(
            'description_title' => $this->description_title,
            'description' => $this->description,
            'address' => $this->address,
            'advertised_rent' => $this->advertised_rent,
            'area' => $this->area,
            'id' => $this->id
        ));
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM rental_unit '
                . 'WHERE id = :id');
        $query->execute(array(
            'id' => $this->id
        ));
    }

}
