<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="./css/login_s.css">
    </head>
    <body>
        <div class="calendar-wrap">
            <table class="calendar">
              <tbody>
                <tr class="week">
                    <td  tabindex="0" colspan="7">
                    <form method="post" action="check_log.php" class="loginForm">
                        <h2>Login</h2>
                        <div class="input-box">
                            <input type="text" id="member_id" name="member_id" required>
                            <label for="member_id">아이디</label>
                        </div>
                        <div class="input-box">
                            <input type="password" id="member_pw" name="member_pw" required>
                            <label for="member_pw">비밀번호</label>
                        </div>
                        <input type="submit" value="로그인">
                        <input type="button" value="회원가입" onClick="location.href='http://localhost/signup.php'">  
                    </form>
                    </td>  
                </tr>
              </tbody>
            </table>  
        </div>
    </body>
</html>