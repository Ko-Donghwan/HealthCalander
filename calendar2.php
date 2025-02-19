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
    <link rel="stylesheet" href="style.css">
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
            <tr><th>아침</th></tr>
            <tr><td>
                <?php while ($info = mysqli_fetch_assoc($rs)) { 
                    echo $info['food_name'] . " - " . $info['calories'] . " kcal<br>";
                    $total_calories += $info['calories'];
                } ?>
            </td></tr>
            <tr><th>점심</th></tr>
            <tr><td>
                <?php while ($info = mysqli_fetch_assoc($rs2)) { 
                    echo $info['food_name'] . " - " . $info['calories'] . " kcal<br>";
                    $total_calories += $info['calories'];
                } ?>
            </td></tr>
            <tr><th>저녁</th></tr>
            <tr><td>
                <?php while ($info = mysqli_fetch_assoc($rs3)) { 
                    echo $info['food_name'] . " - " . $info['calories'] . " kcal<br>";
                    $total_calories += $info['calories'];
                } ?>
            </td></tr>
            <tr><th>전체 칼로리</th></tr>
            <tr><td><?php echo $total_calories; ?> kcal</td></tr>
            <tr><th>초과 칼로리</th></tr>
            <tr><td class="<?php echo ($total_calories > $recommended_calories) ? 'calorie-excess' : 'calorie-ok'; ?>">
                <?php echo ($total_calories > $recommended_calories) ? ($total_calories - $recommended_calories . " kcal 초과") : "권장 칼로리 미달"; ?>
            </td></tr>
            <tr><th>권장 칼로리</th></tr>
            <tr><td><?php echo $recommended_calories; ?> kcal</td></tr>
        </table>

        <h3>오늘의 운동</h3>
        <ul class="exercise-list">
            <?php while ($info = mysqli_fetch_assoc($rs5)) { 
                echo "<li>" . $info['part'] . " / " . $info['exername'] . "</li>";
            } ?>
        </ul>

        <p class="return-link"><a href="calendar.php">캘린더로 돌아가기</a></p>
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

<style>
    /* 기본 스타일 */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        font-family: "Noto Sans KR", sans-serif;
        background: linear-gradient(135deg, #eef2f3 0%, #cfd9df 100%);
        color: #37474f;
        padding: 20px;
    }

    /* 컨테이너 스타일 */
    .container {
        width: 90%;
        max-width: 600px;
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    /* 제목 스타일 */
    h2 {
        font-size: 1.8em;
        color: #37474F;
        margin-bottom: 1rem;
    }

    /* 날짜 선택 */
    form {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.5rem;
    }

    input[type="date"] {
        padding: 10px;
        border: 1px solid #bbb;
        border-radius: 5px;
        font-size: 1rem;
    }

    button {
        padding: 10px 15px;
        background: #0288d1;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s;
    }

    button:hover {
        background: #0277bd;
    }

    /* 테이블 스타일 */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        font-size: 1rem;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background: #0288d1;
        color: white;
        font-weight: bold;
    }

    /* 초과 칼로리 표시 */
    .calorie-excess {
        color: red;
    }

    .calorie-ok {
        color: green;
    }

    /* 운동 정보 */
    .exercise-list {
        list-style: none;
        padding: 0;
        margin-top: 1rem;
    }

    .exercise-list li {
        padding: 10px;
        background: #f1f1f1;
        border-radius: 8px;
        margin: 5px 0;
    }

    /* 캘린더로 돌아가기 링크 */
    .return-link a {
        color: #0288d1;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .return-link a:hover {
        color: #01579b;
    }

    /* Modal styles */
    .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
</style>