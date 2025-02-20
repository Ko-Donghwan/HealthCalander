<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원 가입</title>
    <link rel="stylesheet" href="./css/signup_style.css">
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
                    <input type="radio" id="male" name="member_sex" value="남" required>
                    <label for="male">남성</label>
                    <input type="radio" id="female" name="member_sex" value="여">
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
