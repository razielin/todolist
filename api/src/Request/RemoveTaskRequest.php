<?php
namespace App\Request;
use Symfony\Component\Validator\Constraints as Assert;

class RemoveTaskRequest extends BaseRequest
{
    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    public int $task_id;
}
