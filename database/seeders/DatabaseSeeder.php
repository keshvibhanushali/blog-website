<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use Database\Factories\CategoryFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Post::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'dob' => '2002/02/11',
            'password' => '123',
        ]);

        $author = User::factory()->create([
            'name' => 'pia',
            'email' => 'pia@gmail.com',
            'dob' => '2002/02/11',
            'password' => '123',
        ]);

        $reader = User::factory()->create([
            'name' => 'reader',
            'email' => 'reader@gmail.com',
            'dob' => '2002/02/11',
            'password' => '123',
        ]);

        $roleadmin = Role::create([
            'name' => 'admin',
        ]);

        $roleauthor = Role::create([
            'name' => 'author',
        ]);

        $rolereader = Role::create([
            'name' => 'reader',
        ]);

        $permission_create_cat = Permission::create(
            [
                'name' => 'create_category',
                'module_name' => 'category'
            ],
        );
        $permission_view_cat = Permission::create(
            [
                'name' => 'view_category',
                'module_name' => 'category'
            ],
        );
        $permission_update_cat = Permission::create(
            [
                'name' => 'update_category',
                'module_name' => 'category'
            ],
        );
        $permission_delete_cat = Permission::create(
            [
                'name' => 'delete_category',
                'module_name' => 'category'
            ],
        );
        $permission_create_post = Permission::create(
            [
                'name' => 'create_post',
                'module_name' => 'post'
            ],
        );
        $permission_view_post = Permission::create(
            [
                'name' => 'view_post',
                'module_name' => 'post'
            ],
        );
        $permission_update_post = Permission::create(
            [
                'name' => 'update_post',
                'module_name' => 'post'
            ],
        );
        $permission_delete_post = Permission::create(
            [
                'name' => 'delete_post',
                'module_name' => 'post'
            ],
        );
        $permission_create_user = Permission::create(
            [
                'name' => 'create_user',
                'module_name' => 'user'
            ],
        );
        $permission_view_user = Permission::create(
            [
                'name' => 'view_user',
                'module_name' => 'user'
            ],
        );
        $permission_update_user = Permission::create(
            [
                'name' => 'update_user',
                'module_name' => 'user'
            ],
        );
        $permission_delete_user = Permission::create(
            [
                'name' => 'delete_user',
                'module_name' => 'user'
            ],
        );

        $admin->assignRole($roleadmin->name);
        $author->assignRole($roleauthor->name);
        $reader->assignRole($rolereader->name);

        $roleadmin->givepermissionTo($permission_create_cat->name);
        $roleadmin->givepermissionTo($permission_view_cat->name);
        $roleadmin->givepermissionTo($permission_update_cat->name);
        $roleadmin->givepermissionTo($permission_delete_cat->name);

        $roleadmin->givepermissionTo($permission_create_post->name);
        $roleadmin->givepermissionTo($permission_view_post->name);
        $roleadmin->givepermissionTo($permission_update_post->name);
        $roleadmin->givepermissionTo($permission_delete_post->name);

        $roleadmin->givepermissionTo($permission_create_user->name);
        $roleadmin->givepermissionTo($permission_view_user->name);
        $roleadmin->givepermissionTo($permission_update_user->name);
        $roleadmin->givepermissionTo($permission_delete_user->name);
    }
}
