<?php

namespace App\Factory;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class PostFactory
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    /**
     * @throws \DateMalformedStringException
     * @throws ORMException
     */
    public function makePost(array $data): Post
    {
        $category = $this->entityManager->getReference(Category::class, $data['category_id']);
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setContent($data['content']);
        $post->setPublishedAt(new \DateTimeImmutable($data['published_at']));
        $post->setStatus($data['status']);
        $post->setCategory($category);
        return $post;
    }
}
