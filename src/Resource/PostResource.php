<?php

namespace App\Resource;

use App\DTO\Output\Post\PostOutputDTO;
use App\Entity\Post;
use Symfony\Component\Serializer\SerializerInterface;

class PostResource
{

    public function __construct(private SerializerInterface $serializer){

    }
    public function postItem(PostOutputDTO $dto)
    {

        //первый аргумент что превращаем второй в какой формат
        //третий атрибут мы установили composer require symfony/serializer-pack и в Post entity прописаои что нужно в группу
        return $this->serializer->normalize($dto, 'json', ['groups' => ['post:item']]);

    }


}
