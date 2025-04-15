<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Books;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Books::create([
            'name' => 'diywdisydtgsdiygsdiysdgf',
            'author' => 'JKdo8yddoyd 2',
            'publish_date' => '1999/2/9'
        ]);
    }
}
