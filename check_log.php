<!--로그인 체크-->
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title></title>
</head>
<body>
   <?php
   session_start();
   $host = 'localhost:3307';
   $user = 'root';
   $pw = 'koyuko1870!';
   $db_name = 'madang';
      $mysqli = new mysqli($host, $user, $pw, $db_name); //db 연결
      //login.php에서 입력받은 id, password
      $username = $_POST['member_id'];
      $userpass = $_POST['member_pw'];
      
      $q = "SELECT * FROM member WHERE member_id = '$username' AND member_pw = '$userpass'";
      $result = $mysqli->query($q);
      $row = $result->fetch_array(MYSQLI_ASSOC);
      
      //결과가 존재하면 세션 생성
      if ($row != null) {
         $_SESSION['username'] = $username;
         $_SESSION['name'] = $userpass;
         
         echo "<script>location.replace('http://localhost/calendar.php');</script>";
         exit;

      }
      
      //결과가 존재하지 않으면 로그인 실패
      if($row == null){
         echo "<script>alert('Invalid username or password')</script>";
         echo "<script>location.replace('http://localhost/login_s.php');</script>";
         exit;
      }
      ?>
   </body>