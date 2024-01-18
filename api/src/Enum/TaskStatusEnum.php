<?php

namespace App\Enum;

enum TaskStatusEnum : string
{
    case NEW = 'NEW';
    case VIEWED = 'VIEWED';
    case IMPORTANT = 'IMPORTANT';
    case DONE = 'DONE';
}
