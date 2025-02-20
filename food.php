<?php
ini_set('display_errors', '0');
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Default to current date if not provided

// 페이지 번호 받기 (기본값은 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 100; // 한 페이지에 100개씩 표시
$offset = ($page - 1) * $limit; // OFFSET 계산

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

// 검색어 설정 (SQL 인젝션 방지)
$search_word = "";
if (!empty($_GET["search_word"])) {
    $search_word = mysqli_real_escape_string($conn, $_GET["search_word"]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>음식 추가 화면</title>
    <link rel="stylesheet" href="./css/food_style.css">
    <script type="text/javascript">
        // Function to close the window and redirect
        function goBackToCalendar() {
            window.opener.location.href = 'Today.php?date=<?php echo $selected_date; ?>';
            window.close();
        }
    </script>
</head>
<body>
    <form method="get" action="">
        <input class="search" type="text" name="search_word" placeholder="검색어를 입력 후 enter를 누르세요" autofocus>
        <input type="submit" value="검색">
    </form>

    <?php
    // 검색어 적용하여 데이터 조회 (LIMIT과 OFFSET 적용)
    $sql = "SELECT * FROM food WHERE foodname LIKE '%$search_word%' LIMIT $limit OFFSET $offset"; 
    $rs = mysqli_query($conn, $sql);
    ?>

    <table>
        <tr>
            <th>음식명</th>
            <th>칼로리</th>
            <th>음식 추가</th>
        </tr>
        <?php
            // 총 데이터 개수 확인
            $count_sql = "SELECT COUNT(*) as total FROM food WHERE foodname LIKE '%$search_word%'";
            $count_result = mysqli_query($conn, $count_sql);
            $total_row = mysqli_fetch_assoc($count_result);
            $total_items = $total_row['total'];

            // 총 페이지 수 계산
            $total_pages = ceil($total_items / $limit);
        ?>

        <div class="pagination">
            <?php
            // 이전 페이지 링크 (비활성화 처리)
            if ($page > 1) {
                echo "<button onclick='window.location.href=\"?search_word=$search_word&page=" . ($page - 1) . "\"'>이전</button>";
            } else {
                echo "<button class='disabled' disabled>이전</button>"; // 비활성화된 이전 버튼
            }

            // 다음 페이지 링크 (비활성화 처리)
            if ($page < $total_pages) {
                echo "<button onclick='window.location.href=\"?search_word=$search_word&page=" . ($page + 1) . "\"'>다음</button>";
            } else {
                echo "<button class='disabled' disabled>다음</button>"; // 비활성화된 다음 버튼
            }
            ?>
        </div>
        
        <?php
        if (mysqli_num_rows($rs) > 0) {
            while ($info = mysqli_fetch_assoc($rs)) {
                echo 
                "<tr>
                    <td>{$info['foodname']}</td>
                    <td>{$info['kcal']}</td>
                    <td>
                        <span>
                            <form action='foof_insert.php' method='POST' style='display: inline;'>
                                <input type='hidden' name='fooddate' value='$selected_date'>
                                <input type='hidden' name='username' value='{$_SESSION["username"]}'>
                                <input type='hidden' name='foodname' value='{$info["foodname"]}'>
                                <input type='hidden' name='kcal' value='{$info["kcal"]}'>
                                <input type='hidden' name='morning' value='1'> 
                                <input type='submit' value='아침'>
                            </form>
                            <form action='food_insert.php' method='POST' style='display: inline;'>
                                <input type='hidden' name='fooddate' value='$selected_date'>
                                <input type='hidden' name='username' value='{$_SESSION["username"]}'>
                                <input type='hidden' name='foodname' value='{$info["foodname"]}'>
                                <input type='hidden' name='kcal' value='{$info["kcal"]}'>
                                <input type='hidden' name='lunch' value='2'> 
                                <input type='submit' value='점심'>
                            </form>
                            <form action='food_insert.php' method='POST' style='display: inline;'>
                                <input type='hidden' name='fooddate' value='$selected_date'>
                                <input type='hidden' name='username' value='{$_SESSION["username"]}'>
                                <input type='hidden' name='foodname' value='{$info["foodname"]}'>
                                <input type='hidden' name='kcal' value='{$info["kcal"]}'>
                                <input type='hidden' name='dinner' value='3'> 
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
