<?php

class AmenityRentalUnit extends BaseModel {

    public $rental_unit, $amenity;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function exists($rental_unit, $amenity) {
        $query = DB::connection()->prepare(
                'SELECT * '
                . 'FROM amenity '
                . 'WHERE rental_unit = :rental_unit '
                . 'AND amenity = :amenity');
        $query->execute(array('rental_unit' => $rental_unit, 'amenity' => $amenity));
        $row = $query->fetch();

        if ($row) {
            return true;
        }
        return false;
    }

    public static function delete_amenities_of($id) {
        $query = DB::connection()->prepare('DELETE FROM amenity_rental_unit '
                . 'WHERE rental_unit = :id');
        $query->execute(array('id' => $id));
    }

    public static function create($rental_unit, $amenity) {
        $query = DB::connection()->prepare('INSERT INTO amenity_rental_unit '
                . '(rental_unit, amenity) '
                . 'VALUES (:rental_unit, :amenity);');
        $query->execute(array('rental_unit' => $rental_unit, 'amenity' => $amenity));
    }

    public static function find_amenities_for($id) {
        $query = DB::connection()->prepare(
                'SELECT * FROM AMENITY '
                . 'LEFT JOIN '
                . '(SELECT id as id2, rental_unit '
                . 'FROM AMENITY '
                . 'LEFT JOIN '
                . 'amenity_rental_unit ON amenity.id = amenity_rental_unit.amenity '
                . 'WHERE amenity_rental_unit.rental_unit = :id) '
                . 'AS amenities_of_rental_unit '
                . 'ON amenity.id = amenities_of_rental_unit.id2;');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        $amenities = array();

        foreach ($rows as $row) {
            $amenities[] = new Amenity(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'rental_unit' => $row['rental_unit']
            ));
        }
        return $amenities;
    }

}
