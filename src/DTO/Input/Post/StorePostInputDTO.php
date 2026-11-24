<?php

namespace App\DTO\Input\Post;

use App\Entity\Category;
use App\Validator\Constraint\EntityExists;
use Symfony\Component\Validator\Constraints as Assert;
class StorePostInputDTO
{
 //Атрибуты в DTO публичные!!!
    #[Assert\NotBlank(allowNull: null, normalizer: 'trim')]
    #[Assert\Length(min: 1, max: 255, minMessage: 'Название поста должно быть длиннее')]
    public ?string $title = null;

    #[Assert\NotBlank(allowNull: true, normalizer: 'trim')]
    public ?string $description = null;

    #[Assert\NotBlank(allowNull: null, normalizer: 'trim')]
    public ?string $content = null;

    #[Assert\Type(\DateTimeImmutable::class)]
    public ?\DateTimeImmutable $publishedAt = null;

    #[Assert\NotNull]
    #[Assert\Type(type: 'integer')]
    public ?int $status = null;

    #[Assert\NotNull]
    //Создаем свое правило валидации входных параметров
    #[EntityExists(entity: Category::class)]
    public ?int $categoryId = null;
    public function storePostDTO(array $data)
    {

    }
}
