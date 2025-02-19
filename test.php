<?php
$host = "localhost:3307"; // 데이터베이스 호스트
$user = "root"; // 데이터베이스 사용자 이름
$password = "koyuko1870!"; // 데이터베이스 비밀번호
$dbname = "madang"; // 데이터베이스 이름

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}
?>