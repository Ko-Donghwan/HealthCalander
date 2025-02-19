<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 가입</title>
    <style>
        *,
        *::before,
        *::after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: Arial, sans-serif;
            margin: 0;
            width: 100vw;
            overflow-x: hidden;
        }

        .calendar-wrap {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 300px;
            margin: auto;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #37474F;
        }

        .input-box {
            position: relative;
            margin: 15px 0;
        }

        .input-box input {
            width: 100%;
            padding: 12px 10px;
            font-size: 16px;
            border: none;
            border-bottom: 2px solid #ccc;
            background: transparent;
            outline: none;
            box-sizing: border-box;
        }

        .input-box input:focus {
            border-bottom: solid 2px #0288d1;
            outline: none;
        }

        .input-box label {
            position: absolute;
            left: 10px;
            top: 14px;
            font-size: 16px;
            color: #888;
            transition: 0.3s;
            pointer-events: none;
        }

        .input-box input:focus + label,
        .input-box input:not(:placeholder-shown) + label {
            top: -10px;
            left: 0px;
            font-size: 12px;
            color: #0288d1;
        }

        input[type="submit"], input[type="button"] {
            background-color: #37474F;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 6px;
            width: 100%;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #0288d1;
        }

        #forgot {
            text-align: right;
            font-size: 12px;
            color: #888;
            margin: 10px 0;
        }

        @media (max-width: 500px) {
            .calendar-wrap {
                width: 100%;
                padding: 20px;
            }
        }

        .radio-box {
            margin: 15px 0;
            text-align: left;
        }

        .radio-box label {
            font-size: 16px;
            color: #37474F;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .radio-group {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .radio-group input[type="radio"] {
            display: none; /* 기본 라디오 버튼 숨기기 */
        }

        /* 커스텀 라디오 버튼 */
        .radio-group label {
            position: relative;
            padding-left: 25px;
            cursor: pointer;
            font-size: 16px;
            color: #555;
        }

        /* 원형 버튼 스타일 */
        .radio-group label::before {
            content: "";
            position: absolute;
            left: 0;
            top: 3px;
            width: 16px;
            height: 16px;
            border: 2px solid #ccc;
            border-radius: 50%;
            background: white;
            transition: 0.3s;
        }

        /* 선택된 경우 */
        .radio-group input[type="radio"]:checked + label::before {
            border-color: #0288d1;
            background: #0288d1;
        }

        /* 선택된 경우 내부 점 추가 */
        .radio-group input[type="radio"]:checked + label::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 8px;
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
        }

    </style>
</head>
<body>
    <div class="calendar-wrap">
        <form method="post" action="check_signup.php" class="signupForm">
            <h2>Sign up</h2>
            <div class="input-box">
                <input type="text" name="member_id" placeholder=" " required>
                <label for="member_id">아이디</label>
            </div>
            <div class="input-box">
                <input type="password" name="member_pw" placeholder=" " required>
                <label for="member_pw">비밀번호</label>
            </div>
            <div class="input-box">
                <input type="text" name="member_name" placeholder=" " required>
                <label for="member_name">이름</label>
            </div>
            <div class="input-box">
                <input type="number" name="member_age" placeholder=" " required>
                <label for="member_age">나이</label>
            </div>
            <div class="radio-box">
                <label>성별</label>
                <div class="radio-group">
                    <input type="radio" id="male" name="member_sex" value="남성" required>
                    <label for="male">남성</label>
                    <input type="radio" id="female" name="member_sex" value="여성">
                    <label for="female">여성</label>
                </div>
            </div>
            <div class="input-box">
                <input type="number" name="member_height" placeholder=" " required>
                <label for="member_height">키(cm)</label>
            </div>
            <div class="input-box">
                <input type="number" name="member_weight" placeholder=" " required>
                <label for="member_weight">몸무게(kg)</label>
            </div>
            <input type="submit" value="회원 가입">
        </form>
    </div>
</body>
</html>
