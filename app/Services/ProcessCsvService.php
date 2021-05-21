<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\ImportProcess;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProcessCsvService
{
    /**
     * Import the CSV entties
     *
     * @param ImportProcess $process
     * @return boolean
     */
    public function run(ImportProcess $process): bool
    {
        try {
            DB::transaction(function () use ($process) {
                $file_reader = fopen(storage_path('app/'.$process->filepath), 'r');
                $header_read = false;
                $entries = [];
                while ($row = fgetcsv($file_reader, null, ",")) {
                    if ($header_read) {
                        array_push(
                            $entries,
                            new Entry([
                                'label' => $row[0],
                                'amount' => $row[1],
                                'date' => $row[2],
                            ])
                        );
                    } else {
                        $header_read = true;
                    }
                }
                if (count($entries) > 0) {
                    $process->user->entries()->saveMany($entries);
                }
            });
        } catch (\Exception $e) {
            \Log::error($e);
            return false;
        }
        return true;
    }
}
