<?php

namespace App\Console\Commands;

use App\Services\BannedUsersService;
use Illuminate\Console\Command;

use function PHPUnit\Framework\throwException;

class GetBannedUsers extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'banned-users:get 
                            { --no-admin : Get banned non-admin users }
                            { --admin-only : Get banned admin users }
                            { --active-users-only : Get only banned active users }
                            { --with-trashed : Get banned users including trashed ones }
                            { --trashed-only : Get only trashed banned users }
                            { --sort-by= : Sort the users by email / id / deleted_at }
                            { --with-headers : Include headers in output }
                            { --save-to= : Save output to file }';

    /**
     * The console command description.
     */
    protected $description = 'Get banned users';

    public function handle()
    {   

        if ($this->option('no-admin') && $this->option('admin-only')) {
            $this->error('Must be only admin or olny non admin, cant be both');
            return 1;
        }

        if (($this->option('with-trashed') || $this->option('trashed-only')) && $this->option('active-users-only')) {
            $this->error('Trashed or Deleted cant be active records');
            return 1;
        }

        $options = [
            'noAdmin' => $this->option('no-admin'),
            'adminOnly' => $this->option('admin-only'),
            'activeUsersOnly' => $this->option('active-users-only'),
            'withTrashed' => $this->option('with-trashed'),
            'trashedOnly' => $this->option('trashed-only'),
            'sortBy' => $this->option('sort-by'),
            'withHeaders' => $this->option('with-headers'),
            'saveTo' => $this->option('save-to')
        ];


        try {

            $bannedUsersService = new BannedUsersService($options);

            $users = $bannedUsersService->getUsers();

            $this->table($bannedUsersService->setHeader(), $bannedUsersService->outputResults($users));
            
        } catch (\Exception $e) {

            $this->error($e->getMessage());

            return 1;
        }
    }

    

}

