<?php

class Lease extends BaseModel {

    public $id, $created, $tenant, $tenant_email, $rent, $start_date, $end_date, $rental_unit, $validator;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validation_rules = array(
            'required' => array( array('tenant'), array('tenant_email'), array('rent'), array('start_date'), array('end_date')),
            'email' => array(array('tenant_email')),
            'numeric' => array(array('rent')),
            'date' => array(array('start_date'), array('end_date'))
        );
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM lease WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $lease = new Lease(array(
                'id' => $row['id'],
                'created' => $row['created'],
                'tenant' => $row['tenant'],
                'tenant_email' => $row['tenant_email'],
                'rent' => $row['rent'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'rental_unit' => $row['rental_unit']
            ));
            return $lease;
        }
        return null;
    }

    public static function find_leases_for($id) {
        $query = DB::connection()->prepare('SELECT * FROM lease WHERE lease.rental_unit = :id;');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        $leases = array();

        foreach ($rows as $row) {
            $leases[] = new Lease(array(
                'id' => $row['id'],
                'created' => $row['created'],
                'tenant' => $row['tenant'],
                'tenant_email' => $row['tenant_email'],
                'rent' => $row['rent'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'rental_unit' => $row['rental_unit']
            ));
        }
        return $leases;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO lease '
                . '(created, tenant, tenant_email, rent, start_date, end_date, rental_unit) '
                . 'VALUES (:created, :tenant, :tenant_email, :rent, :start_date, :end_date, :rental_unit);'
        );
        $query->execute(array(
            'created' => date("Y-m-d"),
            'tenant' => $this->tenant,
            'tenant_email' => $this->tenant_email,
            'rent' => $this->rent,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'rental_unit' => $this->rental_unit
        ));
    }

    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM lease '
                . 'WHERE id = :id');
        $query->execute(array(
            'id' => $this->id
        ));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE lease '
                . 'SET '
                . 'tenant = :tenant, '
                . 'tenant_email = :tenant_email, '
                . 'rent = :rent, '
                . 'start_date = :start_date, '
                . 'end_date = :end_date '
                . 'WHERE id = :id');
        $query->execute(array(
            'tenant' => $this->tenant,
            'tenant_email' => $this->tenant_email,
            'rent' => $this->rent,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'id' => $this->id
        ));
    }

}
