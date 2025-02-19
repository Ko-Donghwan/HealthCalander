<?php
    session_start();
    session_destroy(); // 모든 세션 데이터 삭제
    header("Location: login_s.php"); // 로그인 페이지로 이동 (필요한 페이지로 변경 가능)
    exit();
?>