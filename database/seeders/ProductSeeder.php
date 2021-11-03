<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFileName = "products.csv";

        $csvFile =  public_path('csv/' . $csvFileName);
        $data = Helper::readCSV($csvFile);

        foreach($data as $row) {
            DB::table('products')->insert([
                'sku' => $row[0],
                'name' => $row[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }   
    }
}
