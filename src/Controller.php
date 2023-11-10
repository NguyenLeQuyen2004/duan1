<?php

namespace Lequyen\Mvc;

class Controller {
    protected function render($view, $data = []) {
        extract($data);

        include "Views/$view.php";
    }
}
    