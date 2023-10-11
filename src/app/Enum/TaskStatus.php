<?php

namespace App\Enum;

enum TaskStatus: string
{
    case DONE = 'done';
    case UNDONE = 'undone';
}
