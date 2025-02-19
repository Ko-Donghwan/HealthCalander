<?php
session_start();

// 현재 월과 연도를 가져옴 (GET 방식으로 전달된 값이 있으면 그것을 사용)
$month = isset($_GET['month']) ? (int)$_GET['month'] : date("m");
$year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");

// 월이 1보다 작으면 이전 연도의 12월로 변경, 12보다 크면 다음 연도의 1월로 변경
if ($month < 1) {
    $month = 12;
    $year--;
} elseif ($month > 12) {
    $month = 1;
    $year++;
}

// 해당 월의 총 일수 가져오기
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// 해당 월의 첫 번째 날이 무슨 요일인지 확인
$firstDayOfMonth = new DateTime("$year-$month-01");
$startDay = $firstDayOfMonth->format('w'); // 0(일) ~ 6(토)

// 현재 날짜 가져오기
$today = date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>캘린더</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .calendar-wrap {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 450px;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .nav a {
            background: #37474F;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9em;
            transition: background 0.3s;
        }

        .nav a:hover {
            background: #0288d1;
        }

        .calendar {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .calendar th {
            background: #37474F;
            color: white;
            padding: 10px;
            font-size: 0.85em;
        }

        .calendar td {
            padding: 10px;
            text-align: center;
            font-size: 1em;
            border: 1px solid #ddd;
            height: 50px;
            transition: background 0.3s;
        }

        .calendar td a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            text-decoration: none;
            color: #37474F;
            transition: all 0.3s;
        }

        .calendar td a:hover {
            background: #0288d1;
            color: white;
        }

        .today a {
            background: #FF5252 !important;
            color: white !important;
            font-weight: bold;
        }

        p {
            margin-top: 10px;
            font-size: 0.9em;
            color: #555;
        }

        /* 반응형 디자인 */
        @media (max-width: 500px) {
            .calendar-wrap {
                width: 100%;
                padding: 15px;
            }

            .calendar th, .calendar td {
                font-size: 0.75em;
                padding: 8px;
            }

            .calendar td a {
                width: 30px;
                height: 30px;
                line-height: 30px;
            }
        }

        /* 사용자 이름 표시 스타일 */
        .user-info {
            margin-top: 20px;
            padding: 10px 20px;
            background: #f8f9fa;
            border-radius: 25px;
            font-size: 0.9em;
            color: #495057;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .user-info:hover {
            background: #e3e6ea;
        }

        .user-info .user-icon {
            color: #37474F;
        }

        .user-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .logout-btn {
            background: #FF5252;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 0.9em;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #D32F2F;
        }
    </style>
</head>
<body>
    <div class="calendar-wrap">
        <div class="nav">
            <a href="?month=<?= $month - 1; ?>&year=<?= $year; ?>">&#9665; 이전달</a>
            <strong><?= date("F", mktime(0, 0, 0, $month, 1, $year)) . " " . $year ?></strong>
            <a href="?month=<?= $month + 1; ?>&year=<?= $year; ?>">다음달 &#9655;</a>
        </div>
        <table class="calendar">
            <thead>
                <tr>
                    <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $day = 1;
                echo "<tr>";

                // 첫 주 빈 칸 채우기
                for ($i = 0; $i < $startDay; $i++) {
                    echo "<td></td>";
                }

                // 달력 날짜 출력
                for ($i = $startDay; $i < 7; $i++) {
                    $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $class = ($date == $today) ? "today" : "day";
                    echo "<td class='$class'><a href='calendar2.php?date=$date'>$day</a></td>";
                    $day++;
                }
                echo "</tr>";

                while ($day <= $daysInMonth) {
                    echo "<tr>";
                    for ($i = 0; $i < 7; $i++) {
                        if ($day <= $daysInMonth) {
                            $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                            $class = ($date == $today) ? "today" : "day";
                            echo "<td class='$class'><a href='calendar2.php?date=$date'>$day</a></td>";
                            $day++;
                        } else {
                            echo "<td></td>";
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="user-controls">
            <p class="user-info" onclick="location.href='mypage.php';" style="cursor: pointer;">
                <svg class="user-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <?= isset($_SESSION["username"]) ? $_SESSION["username"] : "Guest" ?>
            </p>
            <a href="logout.php" class="logout-btn">로그아웃</a>
        </div>
    </div>
</body>
</html>