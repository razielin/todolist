<?php
namespace App\Service;

use App\Entity\Group;
use App\Entity\Task;
use App\Enum\TaskStatusEnum;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Repository\GroupRepository;
use App\Repository\TaskRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TasksService extends BaseService
{
    private TaskRepository $taskRepository;
    
    public function __construct(TaskRepository $taskRepository, ValidatorInterface $validator)
    {
        parent::__construct($validator);
        $this->taskRepository = $taskRepository;
    }


    /**
     * @param string $taskText
     * @return Task
     * @throws ValidationException
     */
    public function addTask(string $taskText): Task
    {
        $task = new Task($taskText);
        $this->validateOrThrow($task);
        $this->taskRepository->add($task);
        return $task;
    }

    /**
     * @param int $task_id
     * @param string $task_text
     * @return Task
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function editTask(int $task_id, string $task_text): Task
    {
        $task = $this->findTaskOrThrow($task_id);
        $task->setTaskText($task_text);
        $this->validateOrThrow($task);
        $this->taskRepository->add($task);
        return $task;
    }

    /**
     * @param int $task_id
     * @return void
     * @throws NotFoundException
     */
    public function deleteTask(int $task_id): void
    {
        $task = $this->findTaskOrThrow($task_id);
        $this->taskRepository->remove($task);
    }

    public function markAsCompleted(int $task_id): Task
    {
        $task = $this->findTaskOrThrow($task_id);
        $task->setCompleted();
        $this->taskRepository->add($task);
        return $task;
    }

    public function allTasks(): array
    {
        return $this->taskRepository->findAll();
    }

    /**
     * @param $task_id
     * @return Task
     * @throws NotFoundException
     */
    protected function findTaskOrThrow($task_id): Task
    {
        $task = $this->taskRepository->find($task_id);
        if (!$task) {
            throw new NotFoundException("task #$task_id not found");
        }
        return $task;
    }
}
