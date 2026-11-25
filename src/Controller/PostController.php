<?php

namespace App\Controller;

use App\DTOValidator\PostDTOValidator;
use App\Entity\Post;
use App\Factory\PostFactory;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{

    public function __construct(
        private PostService         $postService,
        private PostResponseBuilder $postResponseBuilder,
        private PostDTOValidator    $postDTOValidator,
        private PostFactory         $postFactory,
    )
    {
    }

    //2 способа указать роут это первый или routes.yaml
    #[Route('/api/posts', name: 'index_post', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $posts = $this->postService->index();
        $this->postResponseBuilder->indexPostResponse($posts);
        return $this->postResponseBuilder->indexPostResponse($posts);
    }
    #[Route('/api/posts/{post}', name: 'post_show', methods: ['GET'])]
    public function show(Post $post): JsonResponse
    {
        return $this->postResponseBuilder->showPostResponse($post);
    }

    /**
     * @param Request $request
     * @param PostFactory $postFactory
     * @return JsonResponse
     * @throws \DateMalformedStringException
     */
    #[Route('/api/posts', name: 'post_store', methods: ['POST'])]
    public function store(
        Request $request,
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $storePostInputDTO = $this->postFactory->makeStorePostInputDTO($data);
        $res = $this->postDTOValidator->validate($storePostInputDTO);
        if ($res){
            return $res;
        }
        $post = $this->postService->store($storePostInputDTO);
        return $this->postResponseBuilder->storePostResponse($post);
    }


    #[Route('/api/posts/{post}', name: 'post_post', methods: ['PATCH'])]
    public function update(
        Post $post,
        Request $request,
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $updatePostInputDTO = $this->postFactory->makeUpdatePostInputDTO($data);
        $res = $this->postDTOValidator->validate($updatePostInputDTO);
        if ($res){
            return $res;
        }
        $post = $this->postService->update($post,$updatePostInputDTO);
        return $this->postResponseBuilder->updatePostResponse($post);
    }
    #[Route('/api/posts/{post}', name: 'post_destroy', methods: ['DELETE'])]
    public function destroy(Post $post
    ): JsonResponse
    {
        $this->postService->destroy($post);
        return $this->postResponseBuilder->destroyPostResponse();
    }
}
