<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CommonSeederFunctions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }

    public static function storePhoto($name)
    {
        $n_array = explode('.', $name);
        $file_type = $n_array[count($n_array) - 1];
        $file_name_to_store = substr(base64_encode(microtime()), 3, 6) . '.' . $file_type;
        File::copy("database/seeders/fotos/" . $name, storage_path('app/public/fotos/' . $file_name_to_store));
        return $file_name_to_store;
    }
}
