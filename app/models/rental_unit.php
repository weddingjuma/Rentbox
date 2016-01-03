<?php

class RentalUnit extends BaseModel {

    public $id, $title, $description, $address, $advertised_rent, $landlord, $area, $available;

    public function __construct($attributes) {
        parent::__construct($attributes);
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
                'title' => $row['description_title'],
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
                'title' => $row['description_title'],
                'description' => $row['description'],
                'address' => $row['address'],
                'advertised_rent' => $row['advertised_rent'],
                'area' => $row['area'],
                'landlord' => $row['landlord']
            ));
        }
        return $rental_unit;
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

    public function validateAddress($address) {
        $this->validate_string_length($address, 10);
    }

    public function updateUnit() {
        $query = DB::connection()->prepare('UPDATE rental_unit '
                . 'SET '
                . 'advertised_rent = :advertised_rent, '
                . 'description_title = :title, '
                . 'description = :description '
                . 'WHERE id = :id');
        $query->execute(array(
            'advertised_rent' => $this->advertised_rent,
            'title' => $this->title,
            'description' => $this->description,
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
