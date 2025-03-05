<?php

namespace Database\Seeders;

use App\Models\Konten;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        // User::factory(10)->create();
        User::create([
            'username' => 'admin',  
            'email' => 'a@b.com',
            'password' => md5('123456'), // password       
            'fullname' => 'Admin',    
        ]);

        Konten::create([
            'judul' => 'Selamat Datang',
            'isi' => 'Selamat Datang di Blogku',            
        ]);
    }
}
