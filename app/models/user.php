<?php

class User extends BaseModel {

    public $id, $first_name, $last_name, $email;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function authenticate($email, $password) {
        $query = DB::connection()->prepare(
                'SELECT * FROM system_user '
                . 'WHERE email = :email '
                . 'AND PASSWORD = :password LIMIT 1');
        $query->execute(array('email' => $email, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            return User::find($row['id']);
        } else {
            return null;
        }
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM system_user WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email']
            ));
        }
        return $user;
    }

}
