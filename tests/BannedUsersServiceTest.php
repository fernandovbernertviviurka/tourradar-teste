<?php

use App\Models\User;
use App\Services\BannedUsersService;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;


class BannedUsersServiceTest extends TestCase
{

    /** @test */
    public function it_test_that_get_only_banned_results()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => false,
            'activeUsersOnly' => false,
            'withTrashed' => false,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertNotNull($user->banned_at);

        }
    }

    /** @test */
    public function it_test_get_banned_users_without_any_filter_setted()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => false,
            'activeUsersOnly' => false,
            'withTrashed' => false,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();
        $this->assertNotNull(User::class, $users);
    }

    /** @test */
    public function it_test_get_banned_users_with_active_users_only_filter()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => false,
            'activeUsersOnly' => true,
            'withTrashed' => false,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertNotNull($user->activated_at);

        }
    }

    
    /** @test */
    public function it_test_that_get_only_with_trashed_only_banned_user()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => false,
            'activeUsersOnly' => false,
            'withTrashed' => false,
            'trashedOnly' => true,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();
        foreach($users as $user)
        {
            $this->assertNotNull($user->deleted_at);

        }
    }

    /** @test */
    public function it_test_that_get_only_with_trashed_banned_user()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => false,
            'activeUsersOnly' => false,
            'withTrashed' => true,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertTrue($user->deleted_at || $user->banned_at);
        }
    }

    /** @test */
    public function it_test_that_get_only_non_admin_banned_users()
    {
        $service = new BannedUsersService([
            'noAdmin' => true,
            'adminOnly' => false,
            'activeUsersOnly' => false,
            'withTrashed' => false,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertTrue($role->name != 'admin');
            }
        }
    }

    /** @test */
    public function it_test_that_get_only_non_admin_banned_users_with_active_users_only_filter()
    {
        $service = new BannedUsersService([
            'noAdmin' => true,
            'adminOnly' => false,
            'activeUsersOnly' => true,
            'withTrashed' => false,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertNotNull($user->activated_at);
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertTrue($role->name != 'admin');
            }
        }
    }

    /** @test */
    public function it_test_that_get_only_non_admin_banned_users_with_trashed_filter()
    {
        $service = new BannedUsersService([
            'noAdmin' => true,
            'adminOnly' => false,
            'activeUsersOnly' => false,
            'withTrashed' => true,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertTrue($user->deleted_at || $user->banned_at);
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertTrue($role->name != 'admin');
            }
        }
    }

    /** @test */
    public function it_test_that_get_only_non_admin_banned_users_with_trashed_only_filter()
    {
        $service = new BannedUsersService([
            'noAdmin' => true,
            'adminOnly' => false,
            'activeUsersOnly' => false,
            'withTrashed' => false,
            'trashedOnly' => true,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertTrue($user->deleted_at || $user->banned_at);
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertTrue($role->name != 'admin');
            }
        }
    }


    /** @test */
    public function it_test_that_get_only_admin_banned_users()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => true,
            'activeUsersOnly' => false,
            'withTrashed' => false,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertTrue($role->name == 'admin');
            }
        }
    }

    /** @test */
    public function it_test_that_get_only_admin_banned_users_with_active_users_only_filter()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => true,
            'activeUsersOnly' => true,
            'withTrashed' => false,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertNotNull($user->activated_at);
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertTrue($role->name == 'admin');
            }
        }
    }

    /** @test */
    public function it_test_that_get_only_admin_banned_users_with_trashed_filter()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => true,
            'activeUsersOnly' => false,
            'withTrashed' => true,
            'trashedOnly' => false,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertTrue($user->deleted_at || $user->banned_at);
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertTrue($role->name == 'admin');
            }
        }
    }

    /** @test */
    public function it_test_that_get_only_admin_banned_users_with_trashed_only_filter()
    {
        $service = new BannedUsersService([
            'noAdmin' => false,
            'adminOnly' => true,
            'activeUsersOnly' => false,
            'withTrashed' => false,
            'trashedOnly' => true,
            'sortBy' => 'id',
            'withHeaders' => false,
            'saveTo' => null,
        ]);

        $users = $service->getUsers()->get();

        foreach($users as $user)
        {
            $this->assertTrue($user->deleted_at || $user->banned_at);
            $roles = $user->roles;
            foreach($roles as $role)
            {
                $this->assertNotNull($user->deleted_at);
            }
        }
    }

    
    
}

    
   
