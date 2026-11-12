<?php
require __DIR__.'/../bootstrap.php'; $u=require_login(); $q=$pdo->prepare('SELECT id,name,email,role,points FROM users WHERE id=?'); $q->execute([$u['id']]); $u=$q->fetch(); $_SESSION['user']=$u; respond(['success'=>true,'user'=>$u,'csrf'=>csrf_token()]);
