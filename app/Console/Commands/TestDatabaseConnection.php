<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestDatabaseConnection extends Command
{
    protected $signature = 'db:test-connection';
    protected $description = 'Test the database connection';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            DB::connection()->getPdo();
            $this->info('Database connection is successful.');
        } catch (Exception $e) {
            $this->error('Could not connect to the database. Please check your configuration.');
            $this->error($e->getMessage());
            exit(1);
        }
    }
}
