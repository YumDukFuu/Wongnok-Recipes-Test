# Wongnok-Recipes-Test
Using for PEA DEV Pool 2567
ขอขอบคุณ @PatiphanPhengpao สำหรับพื้นฐานในการสร้าง Web app ดังกล่าว อ้างอิง เรียนรู้การสร้างระบบ CRUD ด้วย PHP ( PDO ) และ Bootstrap 5 Github : https://github.com/ohmiler/pdo-crud-bootstrap5

ขั้นตอนการใช้งาน

1.ติดตั้งโปรแกรม XAMPP (แนะนำ Version v3.3.0) สำหรับ Run ตัวอย่าง Web App
2.เปิดโปรแกรม XAMPP Control Panel และ Start Service Apache และ Service MySQL
3.ดาวน์โหลดไฟล์ member_crud
4.เปิดไฟล์ htdoc ในไดเรคทอรีที่ติดตั้งปรแกรม XAMPP (ตัวอย่างเช่น C:/xampp/htdoc) และคัดลอกไฟล์ member_crud วางไว้ในไฟล์ htdoc
5.เปิดเว็บเบราเซอร์ เข้า http://localhost/ เปิด phpMyAdmin
6.สร้าง Database ชื่อ "member_crud"
7.สร้่าง Table ชื่อ "content" มีแอททริบิว ดังต่อไปนี้ Name Type Collation Attributes Null Default Extra 1 idcontent int(10) No None AUTO_INCREMENT Primary Key 2 topic varchar(255) utf8_general_ci No None 3 content varchar(255) utf8_general_ci No None 4 img varchar(255) utf8_general_ci No None 5 reviewer varchar(255) utf8_general_ci No None
8.สำหรับไฟล์ img_db ที่ใช้เก็บรูปภาพ ให้เปิดสิทธิ์ การ READ/WRITE ให้การไฟล์ดังกล่าว
9.ทดสอบการใช้งาน ปิดเว็บเบราเซอร์ เข้า http://localhost/member_crud/mem_page.php