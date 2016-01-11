<?php

class Amenity extends BaseModel {

    public $id, $name, $description;

    const RENTAL_UNIT = 'rental_unit';
    const LEASE = 'lease';

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM amenity');
        $query->execute();
        $rows = $query->fetchAll();
        $amenities = array();
        foreach ($rows as $row) {
            $amenities[] = new Amenity(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description']
            ));
        }
        return $amenities;
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

    public static function all_and_check($table, $id) {
        if (Amenity::sanitized($table)) {
            $amenities = Amenity::all();
            $amenities_of_model = Amenity::find_amenities_of($table, $id);
            foreach ($amenities as $amenity) {
                if (in_array($amenity->id, $amenities_of_model)) {
                    $amenity->checked = 'checked';
                }
            }
            return $amenities;
        } return null;
    }

    private static function find_amenities_of($table, $id) {
        $sql = 'SELECT amenity FROM ' . 'amenity_' . $table . ' WHERE ' . $table . ' = :id';
        $query = DB::connection()->prepare($sql);
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $amenities = array();
        foreach ($rows as $row) {
            $amenities[] = $row['amenity'];
        }
        return $amenities;
    }

    private static function sanitized($table) {
        if ($table === Amenity::LEASE || $table === Amenity::RENTAL_UNIT) {
            return true;
        } else {
            return false;
        }
    }

    public static function update_amenities_of($table, $id, $params) {
        if (Amenity::sanitized($table)) {
            Amenity::delete_amenities_of($table, $id);
            if (isset($params['amenities'])) {
                foreach ($params['amenities'] as $amenity) {
                    if ($amenity) {
                        Amenity::create($table, $id, $amenity);
                    }
                }
            }
        }
    }

    private static function delete_amenities_of($table, $id) {
        $sql = 'DELETE FROM amenity_' . $table . ' WHERE ' . $table . ' =:id';
        $query = DB::connection()->prepare($sql);
        $query->execute(array('id' => $id));
    }

    private static function create($table, $id, $amenity) {
        $sql = 'INSERT INTO amenity_' . $table . ' (' . $table . ', amenity) VALUES (:id, :amenity)';
        $query = DB::connection()->prepare($sql);
        $query->execute(array('id' => $id, 'amenity' => $amenity));
    }

}
