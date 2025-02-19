<!--로그인 창-->
<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
                font-family: Arial, sans-serif;
                margin: 0;
                width: 100vw; /* 추가 */
                overflow-x: hidden; /* 추가 */
            }

            .calendar-wrap {
                background: #fff;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 90%;
                max-width: 225px;
                margin: auto; /* 추가 */
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

        </style>
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