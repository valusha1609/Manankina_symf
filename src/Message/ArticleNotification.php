<?php

namespace App\Message;

readonly class ArticleNotification
{
    public function __construct(
        private int    $article,
        private string $title,
        private string $body,
        private int    $authorId,
        private bool   $isCreation,
    )
    {

    }

    public function isCreation(): bool
    {
        return $this->isCreation;
    }

    public function getArticle(): int
    {
        return $this->article;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }
}