<?php
// Jalankan sekali melalui browser: http://localhost/gogreen/setup_admin.php
require __DIR__.'/api/bootstrap.php';
$email='admin@gogreen.local'; $password='AdminGoGreen123!';
$q=$pdo->prepare('SELECT id FROM users WHERE email=?');$q->execute([$email]);
if($q->fetch()){echo 'Admin sudah tersedia. Hapus file setup_admin.php setelah selesai.';exit;}
$q=$pdo->prepare("INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,'admin')");$q->execute(['Administrator GoGreen',$email,password_hash($password,PASSWORD_DEFAULT)]);
echo 'Admin berhasil dibuat.<br>Email: '.$email.'<br>Password: '.$password.'<br><b>Segera login dan ganti password. Hapus file setup_admin.php setelah selesai.</b>';
