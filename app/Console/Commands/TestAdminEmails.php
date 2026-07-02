<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AdminEmailNotifier;
use App\Models\User;

class TestAdminEmails extends Command
{
    protected $signature = 'test:admin-emails';
    protected $description = 'Send a test email to all admin users';

    public function handle()
    {
        $admins = User::where('role', 'admin')
            ->whereNotNull('email')
            ->where('email', 'not like', 'pending_%')
            ->pluck('email')
            ->toArray();

        if (empty($admins)) {
            $this->error('No admin users found.');
            return;
        }

        $this->info('Found ' . count($admins) . ' admin(s): ' . implode(', ', $admins));
        $this->info('Sending test email...');

        AdminEmailNotifier::send(
            'Test Email — ArkCrest System',
            '🧪 Test Email',
            '<b>This is a test email</b> sent from the ArkCrest system.<br><br>' .
            'If you received this, email notifications are working correctly.<br>' .
            '<b>Sent at:</b> ' . now()->format('F j, Y g:i A')
        );

        $this->info('Done! Check inboxes of: ' . implode(', ', $admins));
    }
}
