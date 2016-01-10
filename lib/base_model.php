<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validator, $validation_rules;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    private function updateValidator() {
        $this->validator = new Valitron\Validator(get_object_vars($this));
        $this->validator->rules($this->validation_rules);
        $this->validator->validate();
    }

    public function validate() {
        $this->updateValidator();
        return $this->validator->validate();
    }

    public function errors() {
        $this->updateValidator();
        return $this->validator->errors();
    }

}
