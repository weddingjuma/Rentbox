<?php

class User extends BaseModel {

    public $id, $first_name, $last_name, $email, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validation_rules = array(
            'required' => array(array('first_name'), array('last_name'), array('email'), array('password')),
            'email' => array(array('email'))
        );
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

    public static function findWithEmail($email) {
        $query = DB::connection()->prepare('SELECT * FROM system_user WHERE email = :email LIMIT 1');
        $query->execute(array('email' => $email));
        $row = $query->fetch();
        if ($row) {
            $user = new User(array(
                'id' => $row['id'],
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email']
            ));
            return $user;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare(
                'INSERT INTO system_user '
                . '(first_name, last_name, email, password) '
                . 'VALUES (:first_name, :last_name, :email, :password) '
                . 'RETURNING id;');
        $query->execute(array(
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
