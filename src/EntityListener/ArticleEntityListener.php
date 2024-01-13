<?php

namespace App\EntityListener;

use App\Entity\Article;
use App\Message\ArticleNotification;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Article::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'prePersist', entity: Article::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Article::class)]
readonly class ArticleEntityListener
{

    public function __construct(
        private Security            $security,
        private MessageBusInterface $bus
    )
    {
    }

    public function prePersist(\App\Entity\Article $entity): void
    {
//        /** @VAC  Article $entity */
////       $entity =  $event->getObject();
        $entity->setCreatedAt(new \DateTimeImmutable())
            ->setAuthor($this->security->getUser());
    }

    public function postPersist(\App\Entity\Article $entity): void
    {
        $this->bus->dispatch(new ArticleNotification(
            $entity->getId(),
            $entity->getTitle(),
            $entity->getBody(),
            $entity->getAuthor()->getId(),
            true,
        ));
    }

    public function preUpdate(\App\Entity\Article $entity, PreUpdateEventArgs $event): void
    {
        $this->bus->dispatch(new ArticleNotification(
            $entity->getId(),
            $entity->getTitle(),
            $entity->getBody(),
            $entity->getAuthor()->getId(),
            false,
        ));
    }
}