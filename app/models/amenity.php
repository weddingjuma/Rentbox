<?php

class Amenity extends BaseModel {

    public $id, $name, $description, $rental_unit;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM amenity WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $amenity = new Amenity(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description']
            ));
            return $amenity;
        }
        return null;
    }

    public static function find_amenities_for_rental_unit($id) {
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
