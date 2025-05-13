<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'システム管理者001',
            'email' => 'admin001@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '99',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '店舗代表者001',
            'email' => 'owner001@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '店舗代表者002',
            'email' => 'owner002@test.com',
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者001',
            'email' => 'user001@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者002',
            'email' => 'user002@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者003',
            'email' => 'user003@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者004',
            'email' => 'user004@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者005',
            'email' => 'user005@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者006',
            'email' => 'user006@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者007',
            'email' => 'user007@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者008',
            'email' => 'user008@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者009',
            'email' => 'user009@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => '利用者010',
            'email' => 'user010@test.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$Z7CIltwCCqFXbqULPpdxT.VjlLCXUZo3eTHxuERvPkcsrbwboUyiu',
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($param);
    }
}
