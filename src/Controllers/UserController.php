<?php

namespace Lequyen\Mvc\Controllers;

use Lequyen\Mvc\Controller;
use Lequyen\Mvc\Models\User;

class UserController extends Controller {
    public function index() {
        $users = [
            new User('John Doe', 'john@example.com'),
            new User('Jane Doe', 'jane@example.com')
        ];

        $this->render('user/index', ['users' => $users]);
    }
}
    