<?php
require __DIR__.'/../bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST') respond(['success'=>false,'message'=>'Method tidak diizinkan.'],405);
check_csrf(); $d=json_input(); $email=strtolower(trim($d['email']??'')); $password=$d['password']??'';
$q=$pdo->prepare('SELECT id,name,email,password_hash,role,points FROM users WHERE email=? LIMIT 1'); $q->execute([$email]); $u=$q->fetch();
if(!$u || !password_verify($password,$u['password_hash'])) respond(['success'=>false,'message'=>'Email atau password tidak sesuai.'],401);
session_regenerate_id(true); unset($u['password_hash']); $_SESSION['user']=$u; respond(['success'=>true,'message'=>'Berhasil masuk.','user'=>$u]);
