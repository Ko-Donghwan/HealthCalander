<?php
session_start();
$conn = mysqli_connect(
    'localhost:3307',
    'root',
    'koyuko1870!',
    'madang'
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$search_word = mysqli_real_escape_string($conn, $_SESSION["username"]);
$sql = "SELECT * FROM member WHERE member_id LIKE '%$search_word%'"; 
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $member_id = $row['member_id'];
    $member_name = $row['member_name'];
    $member_age = $row['member_age'];
    $member_sex = $row['member_sex'];
    $member_height = $row['member_height'];
    $member_weight = $row['member_weight'];
} else {
    echo "<script>alert('회원 정보를 찾을 수 없습니다.'); window.location.href='login.php';</script>";
    exit();
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        h2 {
            background: #0288d1;
            color: white;
            padding: 15px;
            margin: -20px -20px 20px -20px;
            border-radius: 10px 10px 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #0288d1;
            color: white;
        }

        .btn {
            background: #0288d1;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .btn:hover {
            background: #0277bd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>마이페이지</h2>
        <table>
            <tr>
                <th>아이디</th>
                <td><?php echo htmlspecialchars($member_id); ?></td>
            </tr>
            <tr>
                <th>이름</th>
                <td><?php echo htmlspecialchars($member_name); ?></td>
            </tr>
            <tr>
                <th>나이</th>
                <td><?php echo htmlspecialchars($member_age); ?></td>
            </tr>
            <tr>
                <th>성별</th>
                <td><?php echo htmlspecialchars($member_sex); ?></td>
            </tr>
            <tr>
                <th>키</th>
                <td><?php echo htmlspecialchars($member_height); ?> cm</td>
            </tr>
            <tr>
                <th>몸무게</th>
                <td><?php echo htmlspecialchars($member_weight); ?> kg</td>
            </tr>
        </table>
        <button class="btn" onclick="location.href='calendar.php'">캘린더 화면으로</button>
    </div>
</body>
</html>
