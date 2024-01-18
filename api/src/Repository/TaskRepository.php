<?php

namespace App\Repository;

use App\DTO\UserReportItem;
use App\Entity\Task;
use App\Utils\Paginator;
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
    const TASKS_PER_PAGE = 5;

    private $entityManager;
    private $paginator;


    public function __construct(ManagerRegistry $registry, Paginator $paginator)
    {
        parent::__construct($registry, Task::class);
        $this->entityManager = $registry->getManager();
        $this->paginator = $paginator;
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
     * @return Task[]
     */
    public function getTasksPaginated($page = 1): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery("SELECT t FROM App\Entity\Task t ORDER BY t.task_id DESC");
        $items = $this->paginator->paginate($query, $page, self::TASKS_PER_PAGE)->getItems();

        $res = [];
        foreach ($items as $item) {
            $res[] = $item;
        }
        return $res;
    }

    /**
     * @param Task[] $tasks
     * @return void
     */
    public function incrementViewCount(array $tasks): void
    {
        $ids = implode(',', array_map(fn(Task $t) => $t->getTaskId(), $tasks));
        if (!$ids) {
            return;
        }
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement("
            UPDATE task
            SET task_view_count = task_view_count + 1
            WHERE task_id IN ($ids) 
        ");;
    }
}
