<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Clint;

class CilntSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clint = new Clint();
        $clint->name = 'Clint1';
        $clint->phone = '123456789';
        $clint->address = '123 Street Name';
        $clint->save();
        $clint = new Clint();
        $clint->name = 'Clint2';
        $clint->phone = '987654321';
        $clint->address = '456 Another St';
        $clint->save();
        $clint = new Clint();
        $clint->name = 'Clint3';
        $clint->phone = '555555555';
        $clint->address = '789 Third St';
        $clint->save();
    }
}
