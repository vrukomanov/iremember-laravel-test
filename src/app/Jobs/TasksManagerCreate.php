<?php

namespace App\Jobs;

use App\Enum\TaskStatus;
use App\Models\Task;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Exception\RuntimeException;

class TasksManagerCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
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

        if (empty($this->description)) {
            throw new RuntimeException("Job failed");
        }

        Task::create([
            'description' => $this->description,
            'status' => TaskStatus::tryFrom($this->status) ?? TaskStatus::UNDONE
        ]);
    }
}
