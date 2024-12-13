<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fsdata;

class FSDATASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fsdata = new Fsdata();
        $fsdata->username = "servicios_juanicipio@fresnilloplc.com";
        $fsdata->password = "Ju4n1c1p102k25%";
        $fsdata->grand_type = "password";
        $fsdata->save();
    }
}
