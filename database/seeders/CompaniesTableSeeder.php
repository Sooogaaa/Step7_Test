<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->insert([
            [
                'id' => '3',
                'company_name' => '伊藤園',
                'street_address' => '東京都',
                'representative_name' => '伊藤　太郎',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => '4',
                'company_name' => 'キリン',
                'street_address' => '東京都',
                'representative_name' => '麒麟　太郎',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => '5',
                'company_name' => 'アサヒ飲料',
                'street_address' => '東京都',
                'representative_name' => '朝日　太郎',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => '6',
                'company_name' => 'サンガリア',
                'street_address' => '東京都',
                'representative_name' => '山河　太郎',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => '7',
                'company_name' => 'ダイドードリンコ',
                'street_address' => '東京都',
                'representative_name' => '大東　太郎',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
            ]);
    }
}
