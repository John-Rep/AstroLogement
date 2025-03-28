<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User; // Assure-toi que ceci est correct selon ton projet
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findConversation(User $user1, User $user2): array
    {
        return $this->createQueryBuilder('m')
            ->where('(m.userOrig = :user1 AND m.userDest = :user2) OR (m.userOrig = :user2 AND m.userDest = :user1)')
            ->setParameter('user1', $user1)
            ->setParameter('user2', $user2)
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult();
    }    

    // MessageRepository.php
    public function findLastMessageBetween(User $user1, User $user2): ?Message
    {
        return $this->createQueryBuilder('m')
            ->where('(m.userOrig = :user1 AND m.userDest = :user2) OR (m.userOrig = :user2 AND m.userDest = :user1)')
            ->setParameter('user1', $user1)
            ->setParameter('user2', $user2)
            ->orderBy('m.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    
}
