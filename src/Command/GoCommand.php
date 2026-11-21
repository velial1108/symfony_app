<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use App\Factory\PostFactory;
use App\Resource\PostResource;
use App\ResponseBuilder\PostResponseBuilder;
use App\Service\PostService;
use App\Validator\PostValidator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'GoCommand',
    description: 'Add a short description for your command',
)]
class GoCommand{
//все изменения с таблицами делаются через entityManage
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PostService $postService,
        private PostValidator $postValidator,
        private PostResponseBuilder $postResponseBuilder,
        private PostFactory $postFactory,
    ){

    }

    /**
     * @throws \DateMalformedStringException
     * @throws ORMException
     */
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Argument description')] string $arg = '',
        #[Option('Option description')] bool $enable = false,
    ): int {



        $data = [
            'title'=> 'blablabla',
            'description'=> 'blablabla',
            'content'=> 'blablabla',
            'published_at'=> '2026-11-18',
            'status'=> 2,
            'category_id'=> 1,
        ];
        //Factory для создания
        $post = $this->postFactory->makePost($data);

        // в шаблон класса поместили новые данные и потом сверяем с валидатором
        $this->postValidator->validate($post);


        $post = $this->postService->store($post);
        $res = $this->postResponseBuilder->storePostResponse($post);
        dd($res);

        return Command::SUCCESS;
    }
}
