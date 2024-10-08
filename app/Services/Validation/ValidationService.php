<?php

namespace App\Services\Validation;

class ValidationService
{
    public function validationId($id) {
        return validator(
            ['id' => (int)$id],
            ['id' => 'required|integer']
        );
    }

    public function validationDate($date) {
        return validator(
            ['id' => (int)$date],
            ['id' => 'required|date']
        );
    }
}
