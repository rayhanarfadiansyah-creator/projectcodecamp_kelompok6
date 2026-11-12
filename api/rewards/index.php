<?php
require __DIR__.'/../bootstrap.php'; $u=require_login(); $q=$pdo->query('SELECT id,name,description,points_cost,stock,image FROM rewards WHERE is_active=1 ORDER BY points_cost'); respond(['success'=>true,'points'=>(int)$u['points'],'rewards'=>$q->fetchAll()]);
