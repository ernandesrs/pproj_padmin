<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateSuperuser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'padmin:superuser {--mail=} {--pass=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new super user';

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
        $data = [
            'first_name' => 'Master',
            'last_name' => 'Master Lastname',
            'username' => uniqid('master_'),
            'email' => $this->option('mail'),
            'password' => $this->option('pass'),
            'is_superadmin' => true,
            'email_verified_at' => now(),
        ];

        if (!$data['email']) {
            $this->warn('Fail: mail is missing!');
            return 0;
        }

        if (!$data['password']) {
            $this->warn('Fail: pass is missing!');
            return 0;
        }

        if (User::where('email', $data['email'])->count()) {
            $this->warn('Fail: ' . $data['email'] . ' has been registered!');
            return 0;
        }

        $data['first_name'] = ucfirst(explode('@', $data['email'])[0]);
        if (User::create($data)) {
            $this->info('Superuser registered!');
            return 0;
        }

        return 0;
    }
}
