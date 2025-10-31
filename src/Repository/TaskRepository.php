<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Task> */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /** Renvoie la liste des personnes (distinct) qui ont des tâches */
    public function findDistinctPersons(): array
    {
        $rows = $this->createQueryBuilder('t')
            ->select('DISTINCT t.assignedTo AS person')
            ->andWhere('t.assignedTo IS NOT NULL AND t.assignedTo <> \'\'')
            ->orderBy('t.assignedTo', 'ASC')
            ->getQuery()->getArrayResult();

        return array_map(fn($r) => $r['person'], $rows);
    }
}
