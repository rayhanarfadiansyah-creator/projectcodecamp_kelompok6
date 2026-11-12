<?php
declare(strict_types=1);
$config = require __DIR__ . '/../config/database.php';
$secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Lax']);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: no-store');
try {
  $pdo = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", $config['username'], $config['password'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES=>false]);
} catch (Throwable $e) { http_response_code(503); echo json_encode(['success'=>false,'message'=>'Database belum siap. Periksa konfigurasi XAMPP dan database.']); exit; }
function json_input(): array { $data=json_decode(file_get_contents('php://input'), true); return is_array($data)?$data:$_POST; }
function respond(array $data, int $status=200): never { http_response_code($status); echo json_encode($data, JSON_UNESCAPED_UNICODE); exit; }
function require_login(): array { if (empty($_SESSION['user'])) respond(['success'=>false,'message'=>'Silakan masuk terlebih dahulu.'],401); return $_SESSION['user']; }
function require_admin(): array { $u=require_login(); if (($u['role']??'')!=='admin') respond(['success'=>false,'message'=>'Akses khusus admin.'],403); return $u; }
function csrf_token(): string { if(empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function check_csrf(): void { $token=$_SERVER['HTTP_X_CSRF_TOKEN']??''; if(!$token || !hash_equals(csrf_token(),$token)) respond(['success'=>false,'message'=>'Sesi keamanan tidak valid. Muat ulang halaman.'],419); }
