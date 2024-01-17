<?php

namespace App\Repository;

use App\DTO\UserReportItem;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    private $entityManager;


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
        $this->entityManager = $registry->getManager();
    }

    public function add(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function remove(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }

    /**
     * @return UserReportItem[]
     */
    public function getUsersWithGroups(): array
    {
        $conn = $this->entityManager->getConnection();
        $res = $conn->query("
            SELECT user_id, name, email, 
                   GROUP_CONCAT(group_name) as user_groups, 
                   GROUP_CONCAT(group_id) as group_ids
            FROM user_groups
            LEFT JOIN `user` USING (user_id)
            LEFT JOIN `groups` USING (group_id)
            GROUP BY user_id
        ")->fetchAll();
        return array_map(
            fn($user) => new UserReportItem(
                $user['user_id'], $user['name'], $user['email'], $user['user_groups'], $user['group_ids']
            ),
            $res
        );
    }
}
