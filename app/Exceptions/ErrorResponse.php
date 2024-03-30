<?php

namespace App\Exceptions;

class ErrorResponse {
    public $errors;

    public function __construct($errors) {
        $this->errors = $errors;
    }
}
