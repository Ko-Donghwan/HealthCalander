<?php
  ini_set('display_errors', '0');
  $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Default to current date if not provided
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>운동 추가 화면</title>
        <link rel="stylesheet" href="./css/exercise_style.css">
        <?php
            $conn = mysqli_connect(
                'localhost:3307',
                'root',
                'koyuko1870!',
                'madang'
            );
            
            if (!$conn) {
                die("데이터베이스 연결 실패: " . mysqli_connect_error());
            }

            session_start();
        ?>
        <script type="text/javascript">
            function goBackToCalendar() {
                window.opener.location.href = 'Today.php?date=<?php echo $selected_date; ?>';
                window.close();
            }
        </script>
    </head>
    <body>
    <?php
        $search_word = "";
        if (!empty($_GET["search_word"])) {
            $search_word = mysqli_real_escape_string($conn, $_GET["search_word"]);
        }
    ?>
    <form method="get" action="">
        <input class="search" type="text" name="search_word" placeholder="검색어를 입력 후 enter를 누르세요" autofocus>
        <input type="submit" value="검색">
    </form>

    <?php 
        $sql = "SELECT * FROM exercise WHERE exercise_name LIKE '%$search_word%'"; 
        $rs = mysqli_query($conn, $sql);
    ?>
    <table>
            <tr>
                <th>운동명</th>
                <th>운동 부위</th>  
                <th>운동 추가</th>          
            </tr>    
            <?php
                while( $info = mysqli_fetch_assoc($rs)){
                    echo 
                        "<tr>
                            <td>{$info['exercise_name']}</td>
                            <td>{$info['part']}</td>
                            <td>
                                <form action='exercise_insert.php' method='POST'>
                                    <input type='hidden' name='exerdate' value='$selected_date'>
                                    <input type='hidden' name='username' value='$_SESSION[username]'>
                                    <input type='hidden' name='part' value='$info[part]'>
                                    <input type='hidden' name='exername' value='$info[exercise_name]'>   
                                    <input type='submit' value='추가'>
                                </form>
                            </td>
                        </tr>";
                }
            ?>        
        </table>
    </body>
</html>
<?php
    mysqli_close($conn);
?>