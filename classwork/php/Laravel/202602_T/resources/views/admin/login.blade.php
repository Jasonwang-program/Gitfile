<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group label .required {
            color: #e74c3c;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input.error {
            border-color: #e74c3c;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .captcha-group {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .captcha-input {
            flex: 1;
        }

        .captcha-display {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            padding: 12px 20px;
            min-width: 120px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s ease;
            user-select: none;
        }

        .captcha-display:hover {
            transform: scale(1.05);
        }

        .captcha-display:active {
            transform: scale(0.95);
        }

        .captcha-text {
            font-size: 22px;
            font-weight: bold;
            color: white;
            letter-spacing: 8px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .refresh-hint {
            font-size: 11px;
            color: #999;
            margin-top: 5px;
            text-align: right;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .additional-links {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .additional-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .additional-links a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>會員登入</h1>
            <p>請輸入您的帳號密碼</p>
        </div>

        <form id="loginForm" action="/admin/login" method="post">
            @csrf
            <div class="form-group">
                <label for="userId">
                    帳號 <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <input
                        type="text"
                        id="userIds"
                        name="userId"
                        placeholder="請輸入帳號"
                        autocomplete="off"
                        required
                        value="{{ old('userId') }}">
                    <span class="error-message" id="userIdError">請輸入帳號</span>
                </div>
            </div>

            <div class="form-group">
                <label for="pwd">
                    密碼 <span class="required">*</span>
                </label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="pwd"
                        name="pwd"
                        placeholder="請輸入密碼"
                        autocomplete="current-password"
                        required>
                    <span class="error-message" id="pwdError">請輸入密碼</span>
                </div>
            </div>

            <div class="refresh-hint">
                @if($errors->has("account"))
                <font color="red">{{ $errors->first("account") }}</font>
                @endif
            </div>

            <div class="form-group">
                <label for="code">
                    驗證碼 <span class="required">*</span>
                </label>
                <div class="captcha-group">
                    <div class="captcha-input">
                        <input
                            type="text"
                            id="code"
                            name="code"
                            placeholder="請輸入驗證碼"
                            maxlength="4"
                            required>
                        <span class="error-message" id="codeError">請輸入驗證碼</span>
                    </div>
                    <img src="/captcha/flat" onclick="this.src='/captcha/flat?' + Math.random()" style="cursor:pointer">
                </div>
                <div class="refresh-hint">
                    @if($errors->has("msg"))
                    <font color="red">{{ $errors->first("msg") }}</font>
                    @endif
                </div>
            </div>

            <button type="submit" class="submit-btn">登入</button>
        </form>

        <div class="additional-links">
            <a href="#">忘記密碼？</a>
            <a href="#">註冊新帳號</a>
        </div>
    </div>

    <script>
        // 生成隨機驗證碼
        function generateCaptcha() {
            const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            let captcha = '';
            for (let i = 0; i < 4; i++) {
                captcha += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('captchaText').textContent = captcha;
            return captcha;
        }

        // 頁面載入時生成驗證碼
        window.onload = function() {
            generateCaptcha();
        };

        // 表單驗證
        function validateForm(event) {
            event.preventDefault();

            let isValid = true;

            // 清除之前的錯誤提示
            document.querySelectorAll('.error-message').forEach(msg => {
                msg.classList.remove('show');
            });
            document.querySelectorAll('input').forEach(input => {
                input.classList.remove('error');
            });

            // 驗證帳號 宣告變數可以var, const, let
            const userId = document.getElementById('userId');
            if (!userId.value.trim()) {
                document.getElementById('userIdError').classList.add('show');
                userId.classList.add('error');
                isValid = false;
            }

            // 驗證密碼
            const pwd = document.getElementById('pwd');
            if (!pwd.value.trim()) {
                document.getElementById('pwdError').classList.add('show');
                pwd.classList.add('error');
                isValid = false;
            }

            // 驗證驗證碼
            const code = document.getElementById('code');
            if (!code.value.trim()) {
                document.getElementById('codeError').classList.add('show');
                code.classList.add('error');
                isValid = false;
            }

            if (isValid) {
                // 這裡可以添加實際的登入邏輯
                //alert('表單驗證通過！\n帳號: ' + userId.value + '\n密碼: ' + pwd.value + '\n驗證碼: ' + code.value);
                // 實際應用中應該提交到後端
                document.getElementById('loginForm').submit();
            }

            return false; // 防止表單實際提交
        }

        // 輸入時清除錯誤提示
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('error');
                const errorId = this.id + 'Error';
                document.getElementById(errorId).classList.remove('show');
            });
        });
    </script>
</body>

</html>