<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $csv = new CsvtoArray();
        $file = public_path('website/csv/districts.csv');
        $header = ['code', 'kabupaten_code', 'name', 'latitude', 'longitude'];
        $data = $csv->csv_to_array($file, $header);
        $data = array_map(function ($arr) use ($now) {
            return $arr + ['created_at' => $now, 'updated_at' => $now];
        }, $data);

        $collection = collect($data);
        foreach ($collection->chunk(50) as $chunk) {
            DB::table('kecamatan')->insert($chunk->toArray());
        }
    }
}
