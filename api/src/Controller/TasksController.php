<?php
namespace App\Controller;

use App\Exceptions\BaseException;
use App\Request\AddTaskRequest;
use App\Request\EditTaskRequest;
use App\Service\TasksService;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends BaseController
{

    private TasksService $tasksService;

    public function __construct(TasksService $userService)
    {
        $this->tasksService = $userService;
    }

    /**
     * @Route("/tasks/page/{page}")
     */
    public function tasks(int $page = 1): Response
    {
        $res = $this->tasksService->getTasks($page);
        return $this->toOkJsonResponse($res);
    }

    /**
     * @Route("/tasks/add")
     */
    public function addTask(AddTaskRequest $request): Response
    {
        try {
            $task = $this->tasksService->addTask($request->task_text);
            return $this->toOkJsonResponse($task);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/tasks/edit")
     */
    public function editUser(EditTaskRequest $request): Response
    {
        try {
            $task = $this->tasksService->editTask($request->task_id, $request->task_text);
            return $this->toOkJsonResponse($task);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/tasks/{id}")
     */
    public function deleteTask(int $id): Response
    {
        try {
            $this->tasksService->deleteTask($id);
            return $this->toOkJsonResponse(true);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/tasks/mark_completed/{id}")
     */
    public function taskMarkCompleted(int $id): Response
    {
        try {
            $task = $this->tasksService->markAsCompleted($id);
            return $this->toOkJsonResponse($task);
        } catch (BaseException $e) {
            return $this->toFailJsonResponse([$e->getMessage()]);
        }
    }

    /**
     * @Route("/users/report")
     */
    public function getUsersWithGroups(): Response
    {
        $res = $this->tasksService->getUsersWithGroups();
        return $this->toOkJsonResponse($res);
    }
}
