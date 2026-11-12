<?php
require __DIR__.'/../bootstrap.php'; $u=require_login();
if($_SERVER['REQUEST_METHOD']==='GET'){ $q=$pdo->prepare('SELECT id,title,description,location,status,created_at FROM reports WHERE user_id=? ORDER BY created_at DESC'); $q->execute([$u['id']]); respond(['success'=>true,'reports'=>$q->fetchAll()]); }
if($_SERVER['REQUEST_METHOD']==='POST'){ check_csrf(); $d=json_input(); $title=trim($d['title']??''); $desc=trim($d['description']??''); $loc=trim($d['location']??''); if(mb_strlen($title)<4||mb_strlen($desc)<10) respond(['success'=>false,'message'=>'Judul minimal 4 karakter dan deskripsi minimal 10 karakter.'],422); $q=$pdo->prepare('INSERT INTO reports(user_id,title,description,location) VALUES(?,?,?,?)'); $q->execute([$u['id'],$title,$desc,$loc?:null]); respond(['success'=>true,'message'=>'Laporan berhasil dikirim.']); }
respond(['success'=>false,'message'=>'Method tidak diizinkan.'],405);
