<?php

namespace App\Console\Commands;

use App\Console\AppBuilder;
use Illuminate\Console\Command;

class StartApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'padmin:start {--mail= : The superuser email} {--pass= : The superuser password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start app: create superuser, pages, etc...';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->option('mail')) {
            $this->warn('Fail: mail is missing!');
            return 0;
        }

        if (!$this->option('pass')) {
            $this->warn('Fail: pass is missing!');
            return 0;
        }

        (new AppBuilder())->build($this->option('mail'), $this->option('pass'));

        return 1;
    }
}
