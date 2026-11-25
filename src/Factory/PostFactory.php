<?php

namespace App\Factory;

use App\DTO\Input\Post\StorePostInputDTO;
use App\DTO\Input\Post\UpdatePostInputDTO;
use App\DTO\Output\Post\PostOutputDTO;
use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;

class PostFactory
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }

    /**
     * @throws ORMException
     */
    public function makePost(StorePostInputDTO $storePostInputDTO): Post
    {
        $category = $this->entityManager->getReference(Category::class, $storePostInputDTO->categoryId);
        $post = new Post();
        $post->setTitle($storePostInputDTO->title);
        $post->setDescription($storePostInputDTO->description);
        $post->setContent($storePostInputDTO->content);
        $post->setPublishedAt($storePostInputDTO->publishedAt);
        $post->setStatus($storePostInputDTO->status);
        $post->setCategory($category);
        return $post;
    }

    public function editPost(Post $post,UpdatePostInputDTO $updatePostInputDTO): Post
    {
        $category = $this->entityManager->getReference(Category::class, $updatePostInputDTO->categoryId);
        $post->setTitle($updatePostInputDTO->title);
        $post->setDescription($updatePostInputDTO->description);
        $post->setContent($updatePostInputDTO->content);
        $post->setPublishedAt($updatePostInputDTO->publishedAt);
        $post->setStatus($updatePostInputDTO->status);
        $post->setCategory($category);
        return $post;
    }
    /**
     * @throws \DateMalformedStringException
     */
    public function makeStorePostInputDTO(array $data): StorePostInputDTO
    {
        $post = new StorePostInputDTO();
        $post->title = $data['title'] ?? null;
        $post->description = $data['description'] ?? null;
        $post->content = $data['content'] ?? null;
        $post->publishedAt = new \DateTimeImmutable($data['published_at']) ?? null;
        $post->status = $data['status'] ?? null;
        $post->categoryId = $data['category_id'] ?? null;
        return $post;
    }

    public function makeUpdatePostInputDTO(array $data): UpdatePostInputDTO
    {
        $post = new UpdatePostInputDTO();
        $post->title = $data['title'] ?? null;
        $post->description = $data['description'] ?? null;
        $post->content = $data['content'] ?? null;
        $post->publishedAt = new \DateTimeImmutable($data['published_at']) ?? null;
        $post->status = $data['status'] ?? null;
        $post->categoryId = $data['category_id'] ?? null;
        return $post;
    }

    /**
     * @param Post $post
     * @return PostOutputDTO
     * @throws \DateMalformedStringException
     */
    public function makePostOutputDTO(Post $post): PostOutputDTO
    {
        $postOutputDTO = new PostOutputDTO();
        $postOutputDTO->id = $post->getId();
        $postOutputDTO->title = $post->getTitle();
        $postOutputDTO->description = $post->getDescription();
        $postOutputDTO->content = $post->getContent();
        $postOutputDTO->publishedAt = $post->getPublishedAt();
        $postOutputDTO->status = $post->getStatus();;
        $postOutputDTO->category = $post->getCategory()?->getId();
        $postOutputDTO->tags = array_map(
            static fn (Tag $tag) => ['id' => $tag->getId(), 'title' => $tag->getTitle()],
            $post->getTags()->toArray(),
        );
        return $postOutputDTO;
    }
    public function makePostOutputDTOCollection(array $posts): array
    {
        return array_map(fn ($post) => $this->makePostOutputDTO($post), $posts);
    }
}
