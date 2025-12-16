PHP + MySQL website scaffold

Files created:
- config.php       (DB config + basic bootstrap)
- index.php        (router)
- templates/header.php
- templates/footer.php
- public/css/style.css
- auth/login.php
- auth/logout.php
- auth/register.php
- admin/* (admin pages)
- chat.php (main chat UI)
- db/schema.sql (database schema)

How to run locally:
1) Create a MySQL database and user.
2) Import `db/schema.sql`.
3) Update `config.php` with DB credentials.
4) Place the folder in your web server document root (or use built-in PHP server):
   php -S localhost:8000 -t .
