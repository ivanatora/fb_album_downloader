<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImporterService;

class ImportAlbums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:albums';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import albums from a FB group';

    /**
     * @var ImporterService
     */
    protected $importer;

    public function __construct(ImporterService $importer)
    {
        $this->importer = $importer;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->importer->import();
    }
}