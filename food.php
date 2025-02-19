<?php
  ini_set('display_errors', '0');
  $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Default to current date if not provided
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>php에서 데이터베이스</title>
        <style>
            body {
                color: #666;
                font: 14px/24px "Open Sans", "Helvetica Neue", Arial, sans-serif;
                background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
                margin: 0;
                padding: 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            table {
                border-collapse: collapse;
                width: 90%;
                max-width: 800px;
                background: white;
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            th, td {
                padding: 10px;
                text-align: center;
            }

            th {
                background: #37474F;
                color: white;
                font-size: 16px;
            }

            td {
                border: 1px solid #ddd;
                background: #ffffff;
            }

            tr:nth-child(even) td {
                background: #f1f1f1;
            }

            tr:first-child th:first-child {
                border-top-left-radius: 8px;
            }

            tr:first-child th:last-child {
                border-top-right-radius: 8px;
            }

            tr:last-child td:first-child {
                border-bottom-left-radius: 8px;
            }

            tr:last-child td:last-child {
                border-bottom-right-radius: 8px;
            }

            form {
                width: 90%;
                max-width: 400px;
                margin-bottom: 20px;
                display: flex;
                justify-content: center;
            }

            .search {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 20px;
                font-size: 14px;
                outline: none;
                transition: all 0.3s ease;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            }

            .search:focus {
                border-color: #0288d1;
                box-shadow: 0 4px 8px rgba(2, 136, 209, 0.2);
            }

            input[type="submit"] {
                background: #0288d1;
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 6px;
                cursor: pointer;
                transition: background 0.3s;
            }

            input[type="submit"]:hover {
                background: #01579b;
            }
        </style>
        <?php
            // 데이터베이스 연결
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
            // Function to close the window and redirect
            function goBackToCalendar() {
                window.opener.location.href = 'calendar2.php?date=<?php echo $selected_date; ?>';
                window.close();
            }
        </script>
    </head>
    <body>
        <?php
            // 검색어 설정 (SQL 인젝션 방지)
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
            // 검색어 적용하여 데이터 조회
            $sql = "SELECT * FROM food WHERE foodname LIKE '%$search_word%'"; 
            $rs = mysqli_query($conn, $sql);
        ?>

        <table>
            <tr>
                <th>음식명</th>
                <th>칼로리</th>
                <th>음식 추가</th>
            </tr>    
            <?php
                if (mysqli_num_rows($rs) > 0) {
                    while ($info = mysqli_fetch_assoc($rs)) {
                        echo 
                        "<tr>
                            <td>{$info['foodname']}</td>
                            <td>{$info['kcal']}</td>
                            <td>
                                <span>
                                    <form action='insert.php' method='POST' style='display: inline;'>
                                        <input type='hidden' name='fooddate' value='$selected_date'>
                                        <input type='hidden' name='username' value='{$_SESSION["username"]}'>
                                        <input type='hidden' name='foodname' value='{$info["foodname"]}'>
                                        <input type='hidden' name='kcal' value='{$info["kcal"]}'>
                                        <input type='hidden' name='gg' value='1'> 
                                        <input type='submit' value='아침'>
                                    </form>
                                    <form action='insert.php' method='POST' style='display: inline;'>
                                        <input type='hidden' name='fooddate' value='$selected_date'>
                                        <input type='hidden' name='username' value='{$_SESSION["username"]}'>
                                        <input type='hidden' name='foodname' value='{$info["foodname"]}'>
                                        <input type='hidden' name='kcal' value='{$info["kcal"]}'>
                                        <input type='hidden' name='gg2' value='2'> 
                                        <input type='submit' value='점심'>
                                    </form>
                                    <form action='insert.php' method='POST' style='display: inline;'>
                                        <input type='hidden' name='fooddate' value='$selected_date'>
                                        <input type='hidden' name='username' value='{$_SESSION["username"]}'>
                                        <input type='hidden' name='foodname' value='{$info["foodname"]}'>
                                        <input type='hidden' name='kcal' value='{$info["kcal"]}'>
                                        <input type='hidden' name='gg3' value='3'> 
                                        <input type='submit' value='저녁'>
                                    </form>
                                </span>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>검색 결과가 없습니다.</td></tr>";
                }
            ?>        
        </table>
    </body>
</html>
<?php
    mysqli_close($conn);
?>
