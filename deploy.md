# คู่มือ Deploy FMS Information Portal

เอกสารนี้อธิบายการ deploy โปรเจกต์บน Linux server โดยใช้ Nginx, PHP-FPM และ MySQL/MariaDB ตัวอย่างทั้งหมดสมมติว่า source code อยู่ที่ `/var/www/fms-sri` และผู้ใช้สำหรับ deploy ชื่อ `deploy` ให้ปรับชื่อโดเมน path ผู้ใช้ และ PHP-FPM socket ให้ตรงกับเครื่องจริง

## ความต้องการของระบบ

- PHP 8.3 ขึ้นไป พร้อมส่วนขยาย `ctype`, `curl`, `dom`, `fileinfo`, `filter`, `mbstring`, `openssl`, `pdo`, `session`, `tokenizer`, `xml` และ driver ของฐานข้อมูล เช่น `pdo_mysql`
- Composer 2
- Node.js `20.19+` หรือ `22.12+` และ npm สำหรับ build frontend
- MySQL/MariaDB หรือฐานข้อมูลอื่นที่ Laravel รองรับ
- Nginx และ PHP-FPM
- สิทธิ์เขียนที่ `storage` และ `bootstrap/cache`

ตรวจสอบเวอร์ชันก่อน deploy:

```bash
php -v
composer --version
node --version
npm --version
```

## 1. เตรียมฐานข้อมูลและ source code

สร้างฐานข้อมูลและผู้ใช้ฐานข้อมูลโดยไม่ใช้บัญชี `root` จากนั้นนำ source code ไปไว้บน server:

```bash
sudo mkdir -p /var/www/fms-sri
sudo chown deploy:www-data /var/www/fms-sri
git clone <repository-url> /var/www/fms-sri
cd /var/www/fms-sri
```

ถ้า deploy ด้วยวิธีอื่น เช่น CI/CD artifact ให้คงโครงสร้าง directory เดิม และอย่านำ `.env`, `vendor`, `node_modules` หรือข้อมูลใน `storage/app/public` จากเครื่องพัฒนาไปทับข้อมูลบน production

## 2. ตั้งค่า environment

สร้างไฟล์ `.env` จากตัวอย่างและจำกัดสิทธิ์การอ่าน:

```bash
cp .env.example .env
chmod 640 .env
```

ตั้งค่าอย่างน้อยดังนี้:

```dotenv
APP_NAME="FMS Information Portal"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://example.ac.th

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fms_sri
DB_USERNAME=fms_sri
DB_PASSWORD="change-this-password"

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=database

FILESYSTEM_DISK=local
```

ข้อควรระวัง:

- ห้าม commit `.env` หรือเปิดเผย `APP_KEY`, รหัสผ่านฐานข้อมูล และ credential อื่น
- `APP_URL` ต้องตรงกับ URL จริงและใช้ `https://`
- `APP_DEBUG` ต้องเป็น `false` บน production
- สร้าง `APP_KEY` เพียงครั้งแรกหลังติดตั้ง Composer dependency ในขั้นตอนถัดไป แล้วเก็บค่านี้ไว้ในการสำรองข้อมูล หากเปลี่ยน key ภายหลัง session และข้อมูลที่เข้ารหัสเดิมจะใช้งานไม่ได้

## 3. ติดตั้ง dependency และ build frontend

```bash
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
php artisan key:generate
npm ci
npm run build
```

ผลลัพธ์ frontend จะถูกสร้างใน `public/build` ซึ่งไม่ได้เก็บใน Git หาก build asset ใน CI ให้รวม directory นี้ไว้ใน artifact ที่นำขึ้น server

## 4. ตั้งค่า permission และ public storage

ให้ web server เขียนเฉพาะ directory ที่ Laravel ต้องใช้:

```bash
sudo chown -R deploy:www-data /var/www/fms-sri
sudo chmod -R ug+rwX /var/www/fms-sri/storage /var/www/fms-sri/bootstrap/cache
php artisan storage:link
```

คำสั่ง `storage:link` จำเป็นสำหรับรูปและไฟล์ที่อัปโหลดผ่านระบบ โดยจะเชื่อม `public/storage` ไปยัง `storage/app/public` ส่วนไฟล์ตัวอย่างใน `public/images` ต้องคงอยู่ใน release

## 5. สร้างตารางและ cache สำหรับ production

```bash
php artisan migrate --force
php artisan optimize
```

ไม่ควรรัน `migrate:fresh` บน production เพราะคำสั่งนี้ลบข้อมูลทั้งหมด

ไม่ต้องรัน seeder ในการ deploy ปกติ หากเป็นการติดตั้งครั้งแรกและต้องการข้อมูลตัวอย่างจริง ๆ ให้ตรวจสอบข้อมูลก่อน ตั้ง `ADMIN_NAME`, `ADMIN_EMAIL` และ `ADMIN_PASSWORD` ชั่วคราวใน `.env` แล้วจึงรัน:

```bash
php artisan db:seed --force
```

หลังสร้างผู้ดูแลระบบแล้วให้นำ `ADMIN_PASSWORD` ออกจาก `.env` และเปลี่ยนรหัสผ่านเริ่มต้นผ่านขั้นตอนที่หน่วยงานกำหนด การรัน seeder จะสร้างหรืออัปเดตทั้งบัญชีผู้ดูแลและข้อมูลตัวอย่างของ portal จึงไม่ควรรันโดยไม่ตั้งใจ

## 6. ตั้งค่า Nginx

Document root ต้องชี้ไปที่ `public` เท่านั้น ตัวอย่าง `/etc/nginx/sites-available/fms-sri`:

```nginx
server {
    listen 80;
    server_name example.ac.th;
    root /var/www/fms-sri/public;

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 25M;
}
```

เปิดใช้งาน config ตรวจสอบ syntax แล้ว reload:

```bash
sudo ln -s /etc/nginx/sites-available/fms-sri /etc/nginx/sites-enabled/fms-sri
sudo nginx -t
sudo systemctl reload nginx
```

ติดตั้งใบรับรอง TLS และบังคับ HTTPS ตามมาตรฐานของ server หรือ reverse proxy ที่ใช้งาน หาก TLS สิ้นสุดที่ load balancer/reverse proxy ให้ตรวจสอบการส่ง `X-Forwarded-*` header และ trusted proxy configuration ด้วย

ระบบอนุญาตไฟล์เอกสารขนาดสูงสุด 20 MB จึงควรตั้ง `upload_max_filesize` และ `post_max_size` ใน PHP-FPM ให้ไม่น้อยกว่า 25 MB เช่นเดียวกับ `client_max_body_size` แล้ว restart PHP-FPM หลังแก้ไข

## 7. ตั้งค่า queue worker

โปรเจกต์ตั้งค่า queue เป็น `database` ควรใช้ systemd หรือ Supervisor เพื่อให้ worker ทำงานต่อเนื่อง ตัวอย่าง systemd unit `/etc/systemd/system/fms-sri-queue.service`:

```ini
[Unit]
Description=FMS SRI Laravel Queue Worker
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/var/www/fms-sri
ExecStart=/usr/bin/php artisan queue:work database --sleep=3 --tries=3 --timeout=90
Restart=always
RestartSec=5
TimeoutStopSec=3600

[Install]
WantedBy=multi-user.target
```

เปิดใช้งาน service:

```bash
sudo systemctl daemon-reload
sudo systemctl enable --now fms-sri-queue
sudo systemctl status fms-sri-queue
```

ปัจจุบันโปรเจกต์ยังไม่มี scheduled task ที่กำหนดเอง หากเพิ่ม Laravel scheduler ในอนาคต ให้เพิ่ม cron ต่อไปนี้เพียงหนึ่งรายการ:

```cron
* * * * * cd /var/www/fms-sri && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

## 8. ขั้นตอน update production

สำรองฐานข้อมูลและ `storage/app/public` ก่อนทุกครั้ง โดยเฉพาะ release ที่มี migration จากนั้นรันตามลำดับ:

```bash
cd /var/www/fms-sri
php artisan down --retry=60
git pull --ff-only
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan optimize
php artisan queue:restart
php artisan up
```

ถ้าคำสั่งใดล้มเหลว ให้หยุด ตรวจสอบสาเหตุ และอย่าเปิดระบบด้วย `php artisan up` จนกว่า code, dependency, asset และ migration จะอยู่ในสถานะที่ทำงานร่วมกันได้

ในระบบที่ build ผ่าน CI/CD สามารถแทน `git pull`, `composer install` และ `npm ci && npm run build` ด้วยการติดตั้ง artifact ที่ผ่าน test แล้ว แต่ยังต้องรัน migration, cache, storage link และ restart worker ตามลำดับเดิม

## 9. ตรวจสอบหลัง deploy

```bash
curl --fail https://example.ac.th/up
php artisan migrate:status
php artisan about --only=environment
sudo systemctl status php8.3-fpm nginx fms-sri-queue
tail -n 100 storage/logs/laravel.log
```

ตรวจสอบด้วย browser เพิ่มเติม:

- หน้า portal หลักและหน้ารายการข่าว เอกสาร กิจกรรม บุคลากร และระบบสารสนเทศเปิดได้
- `/admin` redirect ไปหน้า login และผู้ใช้ทั่วไปเข้า admin ไม่ได้
- login ผู้ดูแลระบบได้
- อัปโหลดและแสดงรูป/เอกสารได้ผ่าน `/storage/...`
- asset CSS, JavaScript และฟอนต์โหลดได้โดยไม่มี 404
- `APP_DEBUG=false` และ HTTPS ทำงานถูกต้อง

## Backup และ rollback

ข้อมูลที่ต้องสำรองอย่างน้อยคือ:

- ฐานข้อมูล
- `.env` และ `APP_KEY` โดยจัดเก็บใน secret manager หรือพื้นที่เข้ารหัส
- `storage/app/public`

ก่อน rollback ให้ตรวจสอบว่า migration ของ release ใหม่ย้อนกลับได้และไม่มีข้อมูลใหม่ที่ incompatible กับ code เก่า แนวทางที่ปลอดภัยคือเปิด maintenance mode, กู้ฐานข้อมูล/ไฟล์เมื่อจำเป็น, เปลี่ยนกลับไปยัง release ที่ผ่านการตรวจสอบ, ติดตั้ง dependency และ build asset ของ release นั้น, รัน `php artisan optimize`, restart queue แล้วจึงเปิดระบบ หาก migration มีการลบหรือเปลี่ยนข้อมูล ต้องใช้ backup ที่สร้างก่อน deploy แทนการคาดหวังว่า `migrate:rollback` จะกู้ข้อมูลกลับมาได้ทั้งหมด

## ปัญหาที่พบบ่อย

- **HTTP 500:** ตรวจ `storage/logs/laravel.log`, PHP-FPM log, permission และค่า `.env`
- **หน้าไม่มี CSS/JavaScript:** ตรวจว่า `npm run build` สำเร็จและมี `public/build/manifest.json`
- **รูปอัปโหลดไม่แสดง:** รัน `php artisan storage:link`, ตรวจ `APP_URL`, symlink และ permission ของ `storage/app/public`
- **Login หรือ session ผิดปกติ:** ตรวจว่ารัน migration แล้ว, `SESSION_DRIVER=database`, cookie domain และ HTTPS setting ถูกต้อง
- **ค่าจาก `.env` ไม่เปลี่ยน:** รัน `php artisan optimize:clear` แล้ว `php artisan optimize` ใหม่
- **Queue ไม่ทำงาน:** ตรวจ `systemctl status fms-sri-queue`, ตาราง `jobs`/`failed_jobs` และ restart ด้วย `php artisan queue:restart`
