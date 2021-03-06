<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PerpagesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(DistritosTableSeeder::class);
        $this->call(UnidadesTableSeeder::class);
        $this->call(SintomasTableSeeder::class);
        $this->call(SintomasCadastrosTableSeeder::class);
        $this->call(DoencasBasesTableSeeder::class);
        $this->call(ComorbidadesTableSeeder::class);
        $this->call(RtpcrsTableSeeder::class);
        


        $this->call(acl::class);
    }
}
