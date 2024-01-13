<?php

namespace App\MessageHandler;

use App\Message\ArticleNotification;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ArticleMessageHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(ArticleNotification $message):void
    {
        $this->logger->info(sprintf('Got new message from queue: Article id = %d, title = %s has been %s',
            $message->getArticle(),
            $message->getTitle(),
            $message->isCreation() ? 'created' : 'updated'
        ));

        sleep(3);
    }

}