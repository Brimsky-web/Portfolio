<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password';
    protected $description = 'Reset the admin password with proper bcrypt hashing';

    public function handle()
    {
        $admin = Admin::where('email', 'admin@example.com')->first();

        if (!$admin) {
            $admin = new Admin();
            $admin->name = 'Admin';
            $admin->email = 'admin@example.com';
        }

        $admin->password = Hash::make('password');
        $admin->save();

        $this->info('Admin password has been reset successfully!');
    }
}
