<?php
   error_reporting( E_ALL );
   ini_set( "display_errors", 1 );
   session_start();
   $host = 'localhost:3307';
   $user = 'root';
   $pw = 'koyuko1870!';
   $db_name = 'madang';
   $conn = mysqli_connect($host, $user, $pw, $db_name);
   $signup_id = $_POST['member_id'];
   $signup_pw = $_POST['member_pw'];
   $signup_name = $_POST['member_name'];
   $signup_age = $_POST['member_age'];
   $signup_sex = $_POST['member_sex'];
   $signup_height = $_POST['member_height'];
   $signup_weight = $_POST['member_weight'];
   $sql = "INSERT INTO member VALUES ('$signup_id', '$signup_pw','$signup_name', '$signup_age','$signup_sex', '$signup_height','$signup_weight')";

   if ($signup_id == "" || $signup_pw == ""||$signup_name == "" || $signup_age == ""||$signup_sex == "" || $signup_height == ""||$signup_weight == "") {
      echo '<script>alert("비어있는 항목이 있습니다.");</script>';
      echo '<script>history.back();</script>';
   }

   else {
      mysqli_query($conn, $sql);
      echo '<script>alert("회원 가입이 완료되었습니다.");</script>';
      echo "<script>location.replace('login_s.php');</script>";
   }
?>