<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VillagesSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $csv = new CsvtoArray();
        $resourceFiles = File::allFiles(public_path('website/csv/villages'));
        foreach ($resourceFiles as $file) {
            $header = ['code', 'kecamatan_code', 'name', 'latitude', 'longitude'];
            $data = $csv->csv_to_array($file->getRealPath(), $header);

            $data = array_map(function ($arr) use ($now) {
                return $arr + ['created_at' => $now, 'updated_at' => $now];
            }, $data);

            $collection = collect($data);
            foreach ($collection->chunk(50) as $chunk) {
                DB::table('kelurahan')->insert($chunk->toArray());
            }
        }
    }
}
