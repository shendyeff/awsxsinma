<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'Super Admin')->first();

        // Cek apakah pengguna dengan email admin@gmail.com sudah ada
        $user = User::updateOrCreate(
            ['email' => 'sinmaofficial@gmail.com'],  // Kondisi pencarian
            [   // Data yang akan diupdate atau dibuat
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'department' => 'HRD'
            ]
        );

        // Assign peran jika belum terassign
        if (!$user->hasRole($role)) {
            $user->assignRole($role);
        }
    }
}
