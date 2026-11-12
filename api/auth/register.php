<?php
require __DIR__.'/../bootstrap.php';
if($_SERVER['REQUEST_METHOD']!=='POST') respond(['success'=>false,'message'=>'Method tidak diizinkan.'],405);
check_csrf(); $d=json_input(); $name=trim($d['name']??''); $email=strtolower(trim($d['email']??'')); $password=$d['password']??'';
if(mb_strlen($name)<2 || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($password)<8) respond(['success'=>false,'message'=>'Nama minimal 2 karakter, email harus valid, dan password minimal 8 karakter.'],422);
try { $q=$pdo->prepare('INSERT INTO users(name,email,password_hash,role,points) VALUES(?,?,?,\'user\',0)'); $q->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]); $id=(int)$pdo->lastInsertId(); session_regenerate_id(true); $_SESSION['user']=['id'=>$id,'name'=>$name,'email'=>$email,'role'=>'user','points'=>0]; respond(['success'=>true,'message'=>'Akun berhasil dibuat.','user'=>$_SESSION['user']]); }
catch(PDOException $e){ if($e->getCode()==='23000') respond(['success'=>false,'message'=>'Email sudah terdaftar.'],409); respond(['success'=>false,'message'=>'Pendaftaran gagal.'],500); }
