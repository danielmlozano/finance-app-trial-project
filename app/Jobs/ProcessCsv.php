<?php

namespace App\Jobs;

use App\Events\CsvProcessed;
use App\Models\ImportProcess;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ProcessCsvService;

class ProcessCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The imports process instance
     *
     * @var ImportProcess
     */
    protected $import_process;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ImportProcess $import_process)
    {
        $this->import_process = $import_process;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ProcessCsvService $service)
    {
        if (!$this->import_process->processed) {
            if ($service->run($this->import_process)) {
                broadcast(new CsvProcessed($this->import_process->user));
            } else {
                // TODO: Here we should dispatch a notification for the failure
                // Maybe an email?
            }
        }
    }
}
