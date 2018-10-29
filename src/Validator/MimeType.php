<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class MimeType extends Constraint
{
    public $message = 'File type is not allowed';

    public $mimeTypes = [];

    public function validatedBy()
    {
        return MimeTypeValidator::class;
    }

    public function getPermittedMimeTypes() {
        return $this->mimeTypes;
    }
}
