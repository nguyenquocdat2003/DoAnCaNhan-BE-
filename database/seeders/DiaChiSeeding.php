<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiaChiSeeding extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dia_chis')->delete();

        DB::table('dia_chis')->truncate();

        DB::table('dia_chis')->insert([
            [
                'dia_chi'           =>  'Quảng Ngãi',
                'ten_nguoi_nhan'    =>  'Quốc Đạt',
                'so_dien_thoai'     =>  '0905789123',
                'id_khach_hang'     =>  1,
            ],
            [
                'dia_chi'           =>  'Quảng Ngãi',
                'ten_nguoi_nhan'    =>  'TEAM',
                'so_dien_thoai'     =>  '0905789367',
                'id_khach_hang'     =>  1,
            ],
        ]);
    }
}
