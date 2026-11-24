<?php

namespace App\Controller;

use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{

    public function __construct(
        private PostService $postService,
        private PostResponseBuilder $postResponseBuilder,
    )
    {
    }

    //2 способа указать роут это первый или routes.yaml
    #[Route('/api/posts', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $posts = $this->postService->index();
        $this->postResponseBuilder->indexPostResponse($posts);
        return $this->postResponseBuilder->indexPostResponse($posts);
    }
}
