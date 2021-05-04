<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // アイテムのテストデータ作成
        $names = ['アイテム1', 'アイテム2', 'アイテム3'];
        $sizes = ['16', '12', '8'];

        for ($i=0; $i<3; $i++) {
            DB::table('items')->insert([
                'name' => $names[$i],
                'size' => $sizes[$i],
                'memo' => 'これはアイテム' . ($i+1) . 'です！',
                'room_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
