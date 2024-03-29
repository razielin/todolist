<?php

namespace App\Entity;

use App\Enum\TaskStatusEnum;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task implements \JsonSerializable
{
    const IMPORTANT_TASK_DAYS = 1;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $task_id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $task_text;
    #[ORM\Column(type: 'boolean')]
    private bool $task_completed;
    #[ORM\Column(type: 'datetime')]
    private \DateTime $task_date;
    #[ORM\Column(type: 'integer')]
    private int $task_view_count = 0;

    /**
     * @param string $task_text
     */
    public function __construct(string $task_text)
    {
        $this->task_text = $task_text;
        $this->task_completed = false;
        $this->task_date = new \DateTime();
        $this->task_view_count = 0;
    }


    public function getTaskId(): int
    {
        return $this->task_id;
    }

    public function getTaskText(): string
    {
        return $this->task_text;
    }

    public function isTaskCompleted(): bool
    {
        return $this->task_completed;
    }

    public function setCompleted(): void
    {
        $this->task_completed = true;
    }

    public function getTaskDate(): \DateTime
    {
        return $this->task_date;
    }

    public function getTaskViewCount(): int
    {
        return $this->task_view_count;
    }

    public function setTaskText(string $task_text): void
    {
        $this->task_text = $task_text;
    }

    public function getTaskStatus(): TaskStatusEnum
    {
        if ($this->task_view_count === 0) {
            return TaskStatusEnum::NEW;
        }
        if ($this->isTaskCompleted()) {
            return TaskStatusEnum::DONE;
        }
        if ($this->isImportantTask()) {
            return TaskStatusEnum::IMPORTANT;
        }
        return TaskStatusEnum::VIEWED;
    }

    private function isImportantTask(): bool
    {
        $now = new \DateTime();
        return $this->task_date->diff($now)->days >= self::IMPORTANT_TASK_DAYS;
    }

    public function jsonSerialize()
    {
        return [
            'task_id' => $this->task_id,
            'task_text'  => $this->task_text,
            'task_completed' => $this->task_completed,
            'task_status' => $this->getTaskStatus(),
            'task_date' => $this->task_date->format('Y-m-d H:i:s'),
            'task_view_count' => $this->task_view_count,
        ];
    }
}
