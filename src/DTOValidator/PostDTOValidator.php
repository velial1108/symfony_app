<?php

namespace App\DTOValidator;


use App\DTO\Input\Post\StorePostInputDTO;
use App\DTO\Input\Post\UpdatePostInputDTO;
use App\Exception\ValidateExceprion;
use App\Exception\ValidateException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class PostDTOValidator
{
    public function __construct(private ValidatorInterface $validator,)
    {

    }
    public function validate(StorePostInputDTO|UpdatePostInputDTO $post): ?JsonResponse
    {
        $errors = $this->validator->validate($post);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()][] = $error->getMessage();
            }
            throw new ValidateException((array)json_encode($messages));
        }
        return null;
    }
}
