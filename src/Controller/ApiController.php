<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use App\Service\ArticleServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api.')]
class ApiController extends AbstractController
{
    private const DEFAULT_COUNT = 30;
    #[Route('/articles', methods: ['GET'])]
    public function getArticles(\Symfony\Component\HttpFoundation\Request $request, ArticleServiceInterface $articleService, int $count = self::DEFAULT_COUNT): JsonResponse
    {
        #$count= $request->query->get('count');
        if (!($request->query->has('count') && ctype_digit($request->query->get('count'))))
        {
            $count = self::DEFAULT_COUNT;
        }


        /** @var Article $article */
        foreach ($articleService->getRecentArticles($count)->getQuery()->getResult() as $article)
        {
            $data[] = [
                'id' => $article->getId(),
                'title'=>$article->getTitle(),
                'body'=>$article->getBody(),
                'created_at'=>$article->getCreatedAt()->format('d.m.Y H:i:s'),
                'author'=> [
                    'id'=>$article->getAuthor()->getId(),
                    'name'=>$article->getAuthor()->__Tostring(),
                ]
            ];
        };
        return new JsonResponse($data);
    }
    #[Route('article/{article}', methods: ['GET'])]
    public function article(Article $article): JsonResponse
    {
        return new JsonResponse([
            'id' => $article->getId(),
            'title'=>$article->getTitle(),
            'body'=>$article->getBody(),
            'created_at'=>$article->getCreatedAt()->format('d.m.Y H:i:s'),
            'author'=> [
                'id'=>$article->getAuthor()->getId(),
                'name'=>$article->getAuthor()->__Tostring(),
            ]
        ]);
    }
    #[Route('article', methods: ['POST'])]
    public function createArticle(): JsonResponse
    {

    }
}