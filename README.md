# ระบบร้านเช่าชุด (Costume Rental System)

ระบบร้านเช่าชุดที่พัฒนาด้วย Laravel Framework พร้อมฟีเจอร์ครบครันสำหรับการจัดการร้านเช่าชุด

## ฟีเจอร์หลัก

### 🔐 ระบบ Authentication
- ระบบเข้าสู่ระบบ/สมัครสมาชิก
- แยกสิทธิ์ผู้ใช้ (Admin/Customer)
- ระบบรักษาความปลอดภัย

### 👗 ระบบจัดการชุด
- เพิ่ม/แก้ไข/ลบชุด
- จัดหมวดหมู่ชุด (ชุดไทย, ชุดสากล, ชุดงาน, ชุดแฟนซี)
- อัพโหลดรูปภาพชุด
- กำหนดราคาและสถานะชุด

### 📅 ระบบจองชุด
- จองชุดตามวันที่ต้องการ
- คำนวณราคาอัตโนมัติ
- ติดตามสถานะการจอง
- แก้ไข/ยกเลิกการจอง

### 💳 ระบบชำระเงิน
- อัพโหลดสลิปการโอนเงิน
- ยืนยันการชำระเงิน (Admin)
- ติดตามสถานะการชำระเงิน

### 📊 ระบบแดชบอร์ด
- แดชบอร์ดสำหรับลูกค้า
- แดชบอร์ดสำหรับผู้ดูแลระบบ
- สถิติและรายงาน

## ความต้องการของระบบ

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Web Server (Apache/Nginx)

## การติดตั้ง

### 1. ติดตั้ง Dependencies

```bash
# ติดตั้ง Composer (หากยังไม่มี)
# ดาวน์โหลดจาก https://getcomposer.org/

# ติดตั้ง Laravel Dependencies
composer install
```

### 2. ตั้งค่าสภาพแวดล้อม

```bash
# คัดลอกไฟล์ .env
copy env.example .env

# สร้าง Application Key
php artisan key:generate
```

### 3. ตั้งค่าฐานข้อมูล

แก้ไขไฟล์ `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=costume_rental
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. รัน Migration และ Seeder

```bash
# สร้างตารางในฐานข้อมูล
php artisan migrate

# เพิ่มข้อมูลตัวอย่าง
php artisan db:seed
```

### 5. สร้างลิงก์ Storage

```bash
php artisan storage:link
```

### 6. รันเซิร์ฟเวอร์

```bash
php artisan serve
```

เปิดเบราว์เซอร์ไปที่ `http://localhost:8000`

## บัญชีผู้ใช้ตัวอย่าง

### ผู้ดูแลระบบ
- **อีเมล:** admin@example.com
- **รหัสผ่าน:** password

### ลูกค้าตัวอย่าง
- **อีเมล:** somchai@example.com
- **รหัสผ่าน:** password

- **อีเมล:** somying@example.com
- **รหัสผ่าน:** password

## โครงสร้างโปรเจค

```
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Http/Middleware/     # Custom Middleware
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── resources/
│   └── views/              # Blade Templates
├── routes/
│   ├── web.php            # Web Routes
│   └── api.php            # API Routes
└── storage/
    └── app/public/        # Public Storage
```

## การใช้งาน

### สำหรับลูกค้า
1. สมัครสมาชิกหรือเข้าสู่ระบบ
2. ดูชุดทั้งหมดและค้นหาตามหมวดหมู่
3. เลือกชุดที่ต้องการและจอง
4. อัพโหลดสลิปการโอนเงิน
5. ติดตามสถานะการจอง

### สำหรับผู้ดูแลระบบ
1. เข้าสู่ระบบด้วยบัญชี Admin
2. จัดการชุด (เพิ่ม/แก้ไข/ลบ)
3. ตรวจสอบการจองและยืนยันการชำระเงิน
4. ติดตามสถิติและรายงาน

## เทคโนโลยีที่ใช้

- **Backend:** Laravel 10
- **Frontend:** Bootstrap 5, Font Awesome
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **File Upload:** Laravel Storage

## การพัฒนาต่อ

### ฟีเจอร์ที่สามารถเพิ่มได้
- ระบบแจ้งเตือน (Email/SMS)
- ระบบรีวิวและให้คะแนน
- ระบบส่วนลดและโปรโมชั่น
- ระบบรายงานขั้นสูง
- API สำหรับ Mobile App
- ระบบชำระเงินออนไลน์

### การปรับแต่ง
- แก้ไขหน้าเว็บใน `resources/views/`
- เพิ่มฟีเจอร์ใหม่ใน Controllers
- ปรับแต่งฐานข้อมูลใน Migrations
- เพิ่ม Validation Rules

## การแก้ไขปัญหา

### ปัญหาที่พบบ่อย

1. **Error: Class not found**
   ```bash
   composer dump-autoload
   ```

2. **Storage link ไม่ทำงาน**
   ```bash
   php artisan storage:link
   ```

3. **Permission denied**
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

## การสนับสนุน

หากพบปัญหาหรือต้องการความช่วยเหลือ กรุณาติดต่อทีมพัฒนา

## License

MIT License - ดูรายละเอียดในไฟล์ LICENSE
