<?php

namespace App\Console\Commands;

use App\Models\Activity\Activity;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin
                            {--name= : Name of the user}
                            {--email= : Email address}
                            {--password= : Password}
                            {--role= : Role to assign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create admin';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle(): int
    {
        Activity::all()->each(function (Activity $participant) {
            dd($participant->activity_times);
        });

        $name = $this->option('name') ?? $this->ask('Name');
        $email = $this->option('email') ?? $this->ask('Email address');
        $password = $this->option('password') ?? $this->secret('Password');
        $role = $this->option('role') ?? $this->choice(
            'Role',
            Role::pluck('name')->toArray()
        );

        if (User::where('email', $email)->exists()) {
            $this->error('A user with that email already exists.');
            return static::FAILURE;
        }

        DB::transaction(function () use ($name, $email, $password, $role) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            $user->assignRole($role);
        });

        $this->info("Filament user [$email] created with role [$role].");

        return static::SUCCESS;
    }
}
