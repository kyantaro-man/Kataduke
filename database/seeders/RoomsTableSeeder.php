<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ルームのテストデータの作成
        $names = ['リビング', '自分の部屋', '物置部屋'];
        $sizes = ['112', '88', '44'];
        
        for ($i=0; $i<3; $i++) {
            DB::table('rooms')->insert([
                'name' => $names[$i],
                'size' => $sizes[$i],
                'status' => $i+1,
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
