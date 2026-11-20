<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
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
            'title'=> '',
            'description'=> 'blablabla',
            'content'=> 'blablabla',
            'published_at'=> '2026-11-18',
            'status'=> 2,
            'category_id'=> 1,
        ];
        $category = $this->entityManager->getReference(Category::class, $data['category_id']);
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setDescription($data['description']);
        $post->setContent($data['content']);
        $post->setPublishedAt(new \DateTimeImmutable($data['published_at']));
        $post->setStatus($data['status']);
        $post->setCategory($category);
        // в шаблон класса поместили новые данные и потом сверяем с валидатором
        $this->postValidator->validate($post);


        $post = $this->postService->store($post);
        dd($post);

        return Command::SUCCESS;
    }
}
