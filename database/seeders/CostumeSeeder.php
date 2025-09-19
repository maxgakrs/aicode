<?php

namespace Database\Seeders;

use App\Models\Costume;
use Illuminate\Database\Seeder;

class CostumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $costumes = [
            [
                'name' => 'ชุดไทยประยุกต์สีชมพู',
                'description' => 'ชุดไทยประยุกต์สไตล์โมเดิร์น สีชมพูอ่อน เหมาะสำหรับงานพิเศษต่างๆ',
                'price_per_day' => 500,
                'size' => 'M',
                'color' => 'ชมพู',
                'category' => 'ชุดไทย',
                'status' => 'available',
            ],
            [
                'name' => 'ชุดไทยโบราณสีทอง',
                'description' => 'ชุดไทยโบราณสีทองงาม เหมาะสำหรับงานพระราชพิธีและงานสำคัญ',
                'price_per_day' => 800,
                'size' => 'L',
                'color' => 'ทอง',
                'category' => 'ชุดไทย',
                'status' => 'available',
            ],
            [
                'name' => 'ชุดสากลสีดำ',
                'description' => 'ชุดสากลสีดำสไตล์คลาสสิก เหมาะสำหรับงานเลี้ยงและงานธุรกิจ',
                'price_per_day' => 300,
                'size' => 'S',
                'color' => 'ดำ',
                'category' => 'ชุดสากล',
                'status' => 'available',
            ],
            [
                'name' => 'ชุดสากลสีน้ำเงิน',
                'description' => 'ชุดสากลสีน้ำเงินสไตล์โมเดิร์น เหมาะสำหรับงานเลี้ยงและงานสังคม',
                'price_per_day' => 350,
                'size' => 'M',
                'color' => 'น้ำเงิน',
                'category' => 'ชุดสากล',
                'status' => 'available',
            ],
            [
                'name' => 'ชุดงานสีแดง',
                'description' => 'ชุดงานสีแดงสไตล์เก๋ เหมาะสำหรับงานปาร์ตี้และงานสังสรรค์',
                'price_per_day' => 400,
                'size' => 'L',
                'color' => 'แดง',
                'category' => 'ชุดงาน',
                'status' => 'available',
            ],
            [
                'name' => 'ชุดแฟนซีเจ้าหญิง',
                'description' => 'ชุดแฟนซีเจ้าหญิงสีฟ้า เหมาะสำหรับงานคอสเพลย์และงานเด็ก',
                'price_per_day' => 600,
                'size' => 'S',
                'color' => 'ฟ้า',
                'category' => 'ชุดแฟนซี',
                'status' => 'available',
            ],
            [
                'name' => 'ชุดแฟนซีซูเปอร์ฮีโร่',
                'description' => 'ชุดแฟนซีซูเปอร์ฮีโร่สีแดง เหมาะสำหรับงานคอสเพลย์และงานเด็ก',
                'price_per_day' => 700,
                'size' => 'M',
                'color' => 'แดง',
                'category' => 'ชุดแฟนซี',
                'status' => 'available',
            ],
            [
                'name' => 'ชุดไทยประยุกต์สีเขียว',
                'description' => 'ชุดไทยประยุกต์สีเขียวอ่อน เหมาะสำหรับงานพิเศษและงานสังคม',
                'price_per_day' => 450,
                'size' => 'L',
                'color' => 'เขียว',
                'category' => 'ชุดไทย',
                'status' => 'rented',
            ],
            [
                'name' => 'ชุดสากลสีขาว',
                'description' => 'ชุดสากลสีขาวสไตล์อีเลกกานต์ เหมาะสำหรับงานแต่งงานและงานพิเศษ',
                'price_per_day' => 500,
                'size' => 'M',
                'color' => 'ขาว',
                'category' => 'ชุดสากล',
                'status' => 'maintenance',
            ],
            [
                'name' => 'ชุดงานสีม่วง',
                'description' => 'ชุดงานสีม่วงสไตล์เก๋ เหมาะสำหรับงานปาร์ตี้และงานสังสรรค์',
                'price_per_day' => 380,
                'size' => 'S',
                'color' => 'ม่วง',
                'category' => 'ชุดงาน',
                'status' => 'available',
            ],
        ];

        foreach ($costumes as $costume) {
            Costume::create($costume);
        }
    }
}
