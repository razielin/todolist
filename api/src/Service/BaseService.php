<?php
namespace App\Service;

use App\Exceptions\ValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseService
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }


    protected function validateOrThrow($entity): void
    {
        $errors = $this->validator->validate($entity);
        if (count($errors) > 0) {
            $errorsString = (string)$errors;
            throw new ValidationException($errorsString);
        }
    }
}