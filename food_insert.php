<?php
ini_set('display_errors', '0');
session_start();

$conn = mysqli_connect(
    'localhost:3307',
    'root',
    'koyuko1870!',
    'madang'
);

if (!$conn) {
    die('데이터베이스 연결 실패: ' . mysqli_connect_error());
}

function filter_data($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

if ($_POST["morning"] == 1) {  // 아침 (Morning)
    $filtered = array(
        'user_id' => filter_data($conn, $_POST['username']),
        'food_name' => filter_data($conn, $_POST['foodname']),
        'calories' => filter_data($conn, $_POST['kcal']),
        'food_date' => filter_data($conn, $_POST['fooddate'])
    );

    $sql = "
        INSERT INTO morning_diet (user_id, food_name, calories, food_date)
        VALUES ('{$filtered['user_id']}', '{$filtered['food_name']}', '{$filtered['calories']}', '{$filtered['food_date']}')
    ";

    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        error_log(mysqli_error($conn));
    } else {
        echo '오늘의 식단(아침)에 추가되었습니다. <a href="food.php">돌아가기</a>';
    }

} elseif ($_POST["lunch"] == 2) {  // 점심 (Lunch)
    $filtered = array(
        'user_id' => filter_data($conn, $_POST['username']),
        'food_name' => filter_data($conn, $_POST['foodname']),
        'calories' => filter_data($conn, $_POST['kcal']),
        'food_date' => filter_data($conn, $_POST['fooddate'])
    );

    $sql = "
        INSERT INTO lunch_diet (user_id, food_name, calories, food_date)
        VALUES ('{$filtered['user_id']}', '{$filtered['food_name']}', '{$filtered['calories']}', '{$filtered['food_date']}')
    ";

    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        error_log(mysqli_error($conn));
    } else {
        echo '오늘의 식단(점심)에 추가되었습니다. <a href="food.php">돌아가기</a>';
    }

} elseif ($_POST["dinner"] == 3) {  // 저녁 (Dinner)
    $filtered = array(
        'user_id' => filter_data($conn, $_POST['username']),
        'food_name' => filter_data($conn, $_POST['foodname']),
        'calories' => filter_data($conn, $_POST['kcal']),
        'food_date' => filter_data($conn, $_POST['fooddate'])
    );

    $sql = "
        INSERT INTO dinnet_diet (user_id, food_name, calories, food_date)
        VALUES ('{$filtered['user_id']}', '{$filtered['food_name']}', '{$filtered['calories']}', '{$filtered['food_date']}')
    ";

    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
        error_log(mysqli_error($conn));
    } else {
        echo '오늘의 식단(저녁)에 추가되었습니다. <a href="food.php">돌아가기</a>';
    }
}
?>
