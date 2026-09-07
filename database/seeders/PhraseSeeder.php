<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhraseSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/phrases.csv');

        if (! is_file($path)) {
            throw new \RuntimeException('Missing database/data/phrases.csv. Run: node database/data/build-phrases.mjs');
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        $batch = [];
        $now = now();

        DB::table('user_phrase')->delete();
        DB::table('phrases')->delete();

        while (($row = fgetcsv($handle)) !== false) {
            $item = array_combine($header, $row);
            $batch[] = [
                'phrase' => $item['phrase'],
                'translation_hy' => $item['translation_hy'],
                'translation_ru' => $item['translation_ru'],
                'category' => $item['category'],
                'level' => $item['level'],
                'example_en' => $item['example_en'] ?: null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) === 80) {
                DB::table('phrases')->insert($batch);
                $batch = [];
            }
        }

        if ($batch !== []) {
            DB::table('phrases')->insert($batch);
        }

        fclose($handle);
    }
}
