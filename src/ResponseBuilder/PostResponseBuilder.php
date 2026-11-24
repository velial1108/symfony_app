<?php

namespace App\ResponseBuilder;

use App\Entity\Post;
use App\Factory\PostFactory;
use App\Resource\PostResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostResponseBuilder
{
    public function __construct(
        private PostResource $postResource,
        private  PostFactory $postFactory
    )
    {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function storePostResponse(Post $post, $status = 200, $headers = []): JsonResponse
    {
        $PosOutputDTO = $this->postFactory->makePostOutputDTO($post);
        $postResource = $this->postResource->postItem($PosOutputDTO);
        return new JsonResponse($postResource, $status, $headers);
    }
    public function indexPostResponse(array $posts, $status = 200, $headers = [], ): JsonResponse
    {
        $PosOutputDTOCollection = $this->postFactory->makePostOutputDTOCollection($posts);
        $postResource = $this->postResource->postCollection($PosOutputDTOCollection);
        return new JsonResponse($postResource, $status, $headers);
    }
}
