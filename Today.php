<?php
    session_start();
    $conn = mysqli_connect('localhost:3307', 'root', 'koyuko1870!', 'madang');

    // 현재 날짜 또는 사용자가 선택한 날짜 가져오기
    $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $year = date('Y', strtotime($selected_date));
    $month = date('m', strtotime($selected_date));
    $day = date('d', strtotime($selected_date));

    // 사용자 정보 및 식단 데이터 가져오기
    $user_id = $_SESSION['username'];
    $sql = "SELECT * FROM morning_diet WHERE user_id = '$user_id' AND food_date = '$selected_date'";
    $sql2 = "SELECT * FROM lunch_diet WHERE user_id = '$user_id' AND food_date = '$selected_date'";
    $sql3 = "SELECT * FROM dinnet_diet WHERE user_id = '$user_id' AND food_date = '$selected_date'";
    $sql4 = "SELECT * FROM member WHERE member_id = '$user_id'";
    $sql5 = "SELECT * FROM exerlist WHERE username = '$user_id' AND exerdate = '$selected_date'";

    $rs = mysqli_query($conn, $sql);
    $rs2 = mysqli_query($conn, $sql2);
    $rs3 = mysqli_query($conn, $sql3);
    $rs5 = mysqli_query($conn, $sql5);
    $row = mysqli_fetch_array(mysqli_query($conn, $sql4));

    $member_height = $row[5];
    $recommended_calories = (($member_height - 100) * 0.9) * 32;
    $total_calories = 0;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>월별 식단 관리</title>
    <link rel="stylesheet" href="./css/Today.css">
</head>
<body>
    <div class="container">
        <h2>월별 식단 관리</h2>

        <form method="GET">
            <label for="date">날짜 선택: </label>
            <input type="date" id="date" name="date" value="<?php echo $selected_date; ?>">
            <button type="submit">조회</button>
        </form>

        <button id="foodButton">음식 추가</button>

        <div id="foodModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <iframe src="food.php?date<?php echo $selected_date; ?>" style="width:100%; height:400px; border:none;"></iframe>
            </div>
        </div>

        <button id="exerciseButton">운동 추가</button>

        <div id="exerciseModal" class="modal">
            <div class="modal-content">
                <span class="close exercise-close">&times;</span>
                <iframe src="exercise.php?date=<?php echo $selected_date; ?>" style="width:100%; height:400px; border:none;"></iframe>
            </div>
        </div>

        <h3><?php echo $selected_date; ?>의 식단</h3>
        <table>
            <tr>
                <th>아침</th>
            </tr>
            <tr>
                <td>
                    <?php while ($info = mysqli_fetch_assoc($rs)) { 
                        echo $info['food_name'] . " - " . $info['calories'] . " kcal<br>";
                        $total_calories += $info['calories'];
                    } ?>
                </td>
            </tr>
            <tr>
                <th>점심</th>
            </tr>
            <tr>
                <td>
                <?php while ($info = mysqli_fetch_assoc($rs2)) { 
                    echo $info['food_name'] . " - " . $info['calories'] . " kcal<br>";
                    $total_calories += $info['calories'];
                } ?>
                </td>
            </tr>
            <tr>
                <th>저녁</th>
            </tr>
            <tr>
                <td>
                    <?php while ($info = mysqli_fetch_assoc($rs3)) { 
                        echo $info['food_name'] . " - " . $info['calories'] . " kcal<br>";
                        $total_calories += $info['calories'];
                    } ?>
                </td>
            </tr>
            <tr>
                <th>전체 칼로리</th>
            </tr>
            <tr>
                <td>
                    <?php echo $total_calories; ?> kcal
                </td>
            </tr>
            <tr>
                <th>초과 칼로리</th>
            </tr>
            <tr>
                <td class="<?php echo ($total_calories > $recommended_calories) ? 'calorie-excess' : 'calorie-ok'; ?>">
                    <?php echo ($total_calories > $recommended_calories) ? ($total_calories - $recommended_calories . " kcal 초과") : "권장 칼로리 미달"; ?>
                </td>
            </tr>
            <tr>
                <th>권장 칼로리</th>
            </tr>
            <tr>
                <td>
                    <?php echo $recommended_calories; ?> kcal
                </td>
            </tr>
        </table>

        <h3>오늘의 운동</h3>
        <ul class="exercise-list">
            <?php while ($info = mysqli_fetch_assoc($rs5)) { 
                echo "<li>" . $info['part'] . " / " . $info['exername'] . "</li>";
            } ?>
        </ul>

        <p class="return-link">
            <a href="calendar.php">캘린더로 돌아가기</a>
        </p>
    </div>
    <script>
        // 음식 모달
        var foodModal = document.getElementById("foodModal");
        var foodBtn = document.getElementById("foodButton");
        var foodClose = document.getElementsByClassName("close")[0];

        foodBtn.onclick = function() {
            foodModal.style.display = "block";
        }

        foodClose.onclick = function() {
            foodModal.style.display = "none";
        }

        // 운동 모달
        var exerciseModal = document.getElementById("exerciseModal");
        var exerciseBtn = document.getElementById("exerciseButton");
        var exerciseClose = document.getElementsByClassName("exercise-close")[0];

        exerciseBtn.onclick = function() {
            exerciseModal.style.display = "block";
        }

        exerciseClose.onclick = function() {
            exerciseModal.style.display = "none";
        }

        // 바깥 클릭 시 닫기
        window.onclick = function(event) {
            if (event.target == foodModal) {
                foodModal.style.display = "none";
            }
            if (event.target == exerciseModal) {
                exerciseModal.style.display = "none";
            }
        }
    </script>
</body>
</html>