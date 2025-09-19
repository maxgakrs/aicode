# คู่มือการติดตั้งระบบร้านเช่าชุด

## ขั้นตอนการติดตั้ง

### 1. ติดตั้ง PHP และ Composer

#### Windows:
1. ดาวน์โหลด PHP จาก https://windows.php.net/download/
2. ดาวน์โหลด Composer จาก https://getcomposer.org/download/
3. ติดตั้งและเพิ่ม PATH environment variables

#### หรือใช้ XAMPP:
1. ดาวน์โหลด XAMPP จาก https://www.apachefriends.org/
2. ติดตั้ง XAMPP
3. ติดตั้ง Composer แยกต่างหาก

### 2. ติดตั้ง Dependencies

```bash
# ติดตั้ง Laravel Dependencies
composer install

# ติดตั้ง Node.js Dependencies (ถ้าต้องการ)
npm install
```

### 3. ตั้งค่าสภาพแวดล้อม

```bash
# คัดลอกไฟล์ .env
copy env.example .env

# สร้าง Application Key
php artisan key:generate
```

### 4. ตั้งค่าฐานข้อมูล

แก้ไขไฟล์ `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=costume_rental
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. รัน Migration และ Seeder

```bash
# สร้างตารางในฐานข้อมูล
php artisan migrate

# เพิ่มข้อมูลตัวอย่าง
php artisan db:seed

# สร้างลิงก์ Storage
php artisan storage:link
```

### 6. รันเซิร์ฟเวอร์

```bash
# รัน Laravel Server
php artisan serve

# รัน Vite (ถ้าต้องการ)
npm run dev
```

เปิดเบราว์เซอร์ไปที่ `http://localhost:8000`

## บัญชีทดสอบ

### ผู้ดูแลระบบ
- **อีเมล:** admin@example.com
- **รหัสผ่าน:** password

### ลูกค้าตัวอย่าง
- **อีเมล:** somchai@example.com
- **รหัสผ่าน:** password

- **อีเมล:** somying@example.com
- **รหัสผ่าน:** password

## การแก้ไขปัญหา

### ปัญหาที่พบบ่อย

1. **Composer ไม่พบ**
   - ติดตั้ง Composer จาก https://getcomposer.org/
   - เพิ่ม Composer ใน PATH environment variable

2. **PHP ไม่พบ**
   - ติดตั้ง PHP หรือใช้ XAMPP
   - เพิ่ม PHP ใน PATH environment variable

3. **Database Connection Error**
   - ตรวจสอบการตั้งค่าในไฟล์ .env
   - ตรวจสอบว่า MySQL Server ทำงานอยู่

4. **Storage Link ไม่ทำงาน**
   ```bash
   php artisan storage:link
   ```

5. **Permission Error**
   ```bash
   chmod -R 755 storage/
   chmod -R 755 bootstrap/cache/
   ```

## ฟีเจอร์ของระบบ

- ✅ ระบบ Authentication (Login/Register)
- ✅ ระบบจัดการชุด (CRUD)
- ✅ ระบบจองชุด
- ✅ ระบบจ่ายเงินและอัพโหลดสลิป
- ✅ ระบบแดชบอร์ด
- ✅ หน้าเว็บสวยงามด้วย Bootstrap 5

## การใช้งาน

1. เข้าสู่ระบบด้วยบัญชี Admin หรือ Customer
2. Admin: จัดการชุด, ยืนยันการจอง, ตรวจสอบสลิป
3. Customer: ดูชุด, จองชุด, อัพโหลดสลิปการโอนเงิน

## การสนับสนุน

หากพบปัญหาหรือต้องการความช่วยเหลือ กรุณาติดต่อทีมพัฒนา
