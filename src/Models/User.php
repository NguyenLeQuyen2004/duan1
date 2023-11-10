<?php

namespace Lequyen\Mvc\Models;
use Lequyen\Mvc\Model;


class User extends Model{
    public $name;
    public $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }
}
    