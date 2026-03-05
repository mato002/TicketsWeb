<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email? : The email of the user to make admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user an admin by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        // If email not provided, ask for it
        if (!$email) {
            $email = $this->ask('Enter the email address of the user');
        }

        // Find the user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            
            // Ask if they want to create a new admin user
            if ($this->confirm('Would you like to create a new admin user?')) {
                $name = $this->ask('Enter the name');
                $password = $this->secret('Enter the password');
                
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($password),
                    'is_admin' => true,
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
                
                $this->info("Admin user created successfully!");
                $this->info("Email: {$user->email}");
                $this->info("You can now login at: " . url('/admin/login'));
                return Command::SUCCESS;
            }
            
            return Command::FAILURE;
        }

        // Check if already admin
        if ($user->is_admin) {
            $this->warn("User '{$email}' is already an admin.");
            return Command::SUCCESS;
        }

        // Make user admin
        $user->is_admin = true;
        $user->save();

        $this->info("User '{$email}' has been made an admin successfully!");
        $this->info("They can now login at: " . url('/admin/login'));

        return Command::SUCCESS;
    }
}
