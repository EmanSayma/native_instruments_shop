<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facads\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFileName = "users.csv";

        $csvFile =  public_path('csv/' . $csvFileName);
        $data = Helper::readCSV($csvFile);

        foreach($data as $row) {
            DB::table('users')->insert([
                'name' => $row[1],
                'email' => $row[2],
                'password' => bcrypt($row[3]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }  
    }
}
