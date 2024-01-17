<?php
namespace App\Request;
use Symfony\Component\Validator\Constraints as Assert;

class AddTaskRequest extends BaseRequest
{
    #[Assert\NotBlank]
    public string $task_text;
}
