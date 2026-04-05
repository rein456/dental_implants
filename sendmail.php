<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo json_encode(['ok' => false]);
	exit;
}

$name = trim($_POST['name'] ?? '');
$tel = trim($_POST['tel'] ?? '');
$email = trim($_POST['email'] ?? '');

$to = 'beladentstomat@gmail.com';

$subject = 'Нова заявка з сайту';

$message =
	"Нова заявка:\n\n" .
	"Імʼя: $name\n" .
	"Телефон: $tel\n" .
	"Email: $email\n" .
	"Сторінка: " . ($_SERVER['HTTP_REFERER'] ?? '-') . "\n";

$headers = [
	'MIME-Version: 1.0',
	'Content-Type: text/plain; charset=utf-8',
	'From: Site <no-reply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '>'
];

if ($email) {
	$headers[] = 'Reply-To: ' . $email;
}

$sent = mail(
	$to,
	'=?UTF-8?B?' . base64_encode($subject) . '?=',
	$message,
	implode("\r\n", $headers)
);

echo json_encode(['ok' => $sent]);
