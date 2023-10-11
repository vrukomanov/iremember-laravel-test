<?php

namespace App\Jobs;

use App\Enum\TaskStatus;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TasksManagerUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $id,
        private readonly ?string $description = null,
        private readonly ?string $status = null
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(10);

        $task = Task::findOrFail($this->id);

        if (!empty($this->description)) {
            $task->description = $this->description;
        }
        if (!empty($this->status)) {
            $task->status = TaskStatus::from($this->status);
        }

        $task->save();
    }
}
