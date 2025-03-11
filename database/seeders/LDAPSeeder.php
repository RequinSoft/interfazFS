<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ldap;

class LDAPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $ldap = new Ldap();
        $ldap->servers = "127.0.0.1";
        $ldap->port = 539;
        $ldap->user = "admin";
        $ldap->domain = "ad.local.com";
        $ldap->password = "ninguna";
        $ldap->save();
    }
}
