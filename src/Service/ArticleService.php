<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Psr\Log\LoggerInterface;


readonly class ArticleService implements ArticleServiceInterface
{



    public function __construct(
        private ArticleRepository $articleRepository,
        private LoggerInterface   $logger)
    {
    }

    public function getRecentArticles(int $count, ?string $search = null): \Doctrine\ORM\QueryBuilder
    {
        $this->logger->info(sprintf('getting %d recent articles', $count));
        return $this ->articleRepository->getRecentArticles($count, $search);
    }

    public function getSingleArticleById(int $id): ?Article
    {
        return $this->articleRepository->find($id);
    }

}