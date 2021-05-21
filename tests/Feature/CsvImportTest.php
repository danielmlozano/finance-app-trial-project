<?php

namespace Tests\Feature;

use App\Events\CsvProcessed;
use App\Jobs\ProcessCsv;
use App\Models\ImportProcess;
use App\Models\User;
use App\Services\ProcessCsvService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CsvImportTest extends TestCase
{
    use RefreshDatabase;

    public function testCsvCanBeUploaded()
    {
        $this->actingAs(User::factory()->create(), 'sanctum');
        Storage::fake('local');
        Bus::fake();

        $fake_csv_header = 'Label,Value,Date';
        $fake_csv_rows = [
            "Car Insurance,-185.15,2016-01-16 18:02:17",
            "Groceries,-69.52,1986-07-20 04:17:58",
            "Rent,-148.91,1975-07-25 11:02:59",
            "Lotter,856.61,1983-11-04 11:26:02",
            "Salar,234.29,2007-03-15 13:38:12",
            "Car Insurance,-55.73,2013-02-02 21:51:56",
            "Utility Bill,-3.21,1985-04-11 12:31:54",
            "Lotter,575.88,2018-01-13 01:18:23",
            "Salar,303.57,2016-07-13 05:51:57",
            "Refun,669.01,2008-03-04 04:29:01",
         ];
        $fake_csv_content = [$fake_csv_header];
        foreach ($fake_csv_rows as $row) {
            array_push($fake_csv_content, $row);
        }

        $data = [
            'file' => UploadedFile::fake()->createWithContent(
                'test.csv',
                implode("\n", $fake_csv_content)
            )
        ];

        $response = $this->postJson('/api/entries/import', $data);

        $content = json_decode($response->getContent(), true);

        $response->assertStatus(201);
        $this->assertEquals(10, $content['imported_rows']);
        $this->assertDatabaseCount('import_processes', 1);
        Storage::disk('local')->assertExists('csv/'.$data['file']->hashName());
        Bus::assertDispatched(ProcessCsv::class);
    }

    public function testProcessCsvService()
    {
        // This test assumes that a test.csv with 10 entries exists at
        // storage/app/csv/test.csv

        Event::fake();
        $user = User::factory()->create();

        $process = ImportProcess::factory()->for($user)->create();

        ProcessCsv::dispatchSync($process);

        Event::assertDispatched(CsvProcessed::class);

        $this->assertEquals(10, $user->entries->count());
    }
}
