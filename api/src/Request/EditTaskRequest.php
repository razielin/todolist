<?php
namespace App\Request;
use Symfony\Component\Validator\Constraints as Assert;

class EditTaskRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    public int $task_id;

    #[Assert\NotBlank]
    public string $task_text;
}
