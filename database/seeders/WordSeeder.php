<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/words.csv');

        if (! is_file($path)) {
            throw new \RuntimeException('Missing database/data/words.csv. Run: node database/data/build-words.mjs');
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        $batch = [];
        $now = now();

        DB::table('user_word')->delete();
        DB::table('words')->delete();

        while (($row = fgetcsv($handle)) !== false) {
            $item = array_combine($header, $row);
            $batch[] = [
                'word' => $item['word'],
                'translation_hy' => $item['translation_hy'] ?: null,
                'translation_ru' => $item['translation_ru'] ?: null,
                'level' => $item['level'],
                'part_of_speech' => $item['part_of_speech'] ?: null,
                'frequency_rank' => (int) $item['frequency_rank'],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) === 80) {
                DB::table('words')->insert($batch);
                $batch = [];
            }
        }

        if ($batch !== []) {
            DB::table('words')->insert($batch);
        }

        fclose($handle);
    }
}
