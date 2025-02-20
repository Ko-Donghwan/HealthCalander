<?php
  session_start();
  $_SESSION["username"];
?>
<?php
  $conn = mysqli_connect(
    'localhost:3307',
    'root',
    'koyuko1870!',
    'madang'
  );
  $filtered = array(
    'username' => mysqli_real_escape_string($conn, $_POST['username']),
    'exername' => mysqli_real_escape_string($conn, $_POST['exername']),
    'part' => mysqli_real_escape_string($conn, $_POST['part']),
    'exerdate' => mysqli_real_escape_string($conn, $_POST['exerdate'])
  );
  $sql = "
  INSERT INTO exerlist (username, exername, part, exerdate) VALUES ( 
    '{$filtered['username']}',  
    '{$filtered['exername']}',
    '{$filtered['part']}',
    '{$filtered['exerdate']}'
  )";
  $result = mysqli_query($conn, $sql);
  if ($result === false) {
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
  } else {
    echo '오늘의 운동에 추가되었습니다. <a href="exercise.php">돌아가기</a>';
  }
  ;
?>