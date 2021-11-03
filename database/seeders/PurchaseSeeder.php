<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facads\Hash;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFileName = "purchased.csv";

        $csvFile =  public_path('csv/' . $csvFileName);
        $data = Helper::readCSV($csvFile);

        foreach($data as $row) {
            DB::table('purchases')->insert([
                'user_id' => $row[0],
                'product_sku' => $row[1],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        } 
    }
}
