<?php
    session_start();
    // 현재 월과 연도를 가져옴
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
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 해당 월의 총 일수 가져오기

    $firstDayOfMonth = new DateTime("$year-$month-01");
    $startDay = $firstDayOfMonth->format('w'); 

    $today = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>캘린더</title>
    <link rel="stylesheet" href="./css/calendar_style.css">
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

                    for ($i = 0; $i < $startDay; $i++) {
                        echo "<td></td>";
                    }

                    for ($i = $startDay; $i < 7; $i++) {
                        $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                        $class = ($date == $today) ? "today" : "day";
                        echo "<td class='$class'><a href='Today.php?date=$date'>$day</a></td>";
                        $day++;
                    }
                    echo "</tr>";

                    while ($day <= $daysInMonth) {
                        echo "<tr>";
                        for ($i = 0; $i < 7; $i++) {
                            if ($day <= $daysInMonth) {
                                $date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                                $class = ($date == $today) ? "today" : "day";
                                echo "<td class='$class'><a href='Today.php?date=$date'>$day</a></td>";
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