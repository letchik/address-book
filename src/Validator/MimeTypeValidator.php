<?php
namespace App\Validator;

use App\Entity\File;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MimeTypeValidator extends ConstraintValidator
{
    /**
     * @param File $file
     * @param MimeType $constraint
     * @return bool
     */
    public function validate($file, Constraint $constraint)
    {
        if (empty($file)) {
            return false;
        }

        $mimeType = $file->getMime();

        if (!in_array($mimeType, $constraint->getPermittedMimeTypes())) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return false;
        }
        return true;
    }
}
