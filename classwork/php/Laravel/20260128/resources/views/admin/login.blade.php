{{-- resources/views/admin/login.blade.php --}}

<!doctype html>
<html lang="zh-TW">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>管理登入</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        :root {
            --bg-primary: #fff8e7;
            --bg-secondary: #ffe9c5;
            --card-bg: rgba(255, 255, 255, 0.85);
            --card-border: rgba(251, 191, 36, 0.3);
            --text-primary: #78350f;
            --text-secondary: #92400e;
            --text-muted: #a16207;
            --accent-orange: #f97316;
            --accent-orange-dark: #ea580c;
            --accent-amber: #f59e0b;
            --danger: #dc2626;
            --danger-bg: rgba(220, 38, 38, 0.1);
            --focus-ring: rgba(251, 146, 60, 0.3);
            --input-bg: rgba(255, 255, 255, 0.7);
            --input-border: rgba(251, 191, 36, 0.4);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Noto Sans TC", sans-serif;
            color: var(--text-primary);
            background:
                radial-gradient(ellipse 1400px 900px at 15% 10%, rgba(251, 191, 36, 0.2), transparent 50%),
                radial-gradient(ellipse 1200px 800px at 85% 20%, rgba(249, 115, 22, 0.15), transparent 50%),
                radial-gradient(ellipse 1000px 600px at 50% 80%, rgba(245, 158, 11, 0.12), transparent 50%),
                linear-gradient(135deg, #fff8e7 0%, #ffe9c5 50%, #fed7aa 100%);
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            position: relative;
            overflow: hidden;
        }

        /* 動態背景粒子效果 */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 30%, rgba(251, 191, 36, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(249, 115, 22, 0.08) 0%, transparent 50%);
            animation: pulse 8s ease-in-out infinite alternate;
            pointer-events: none;
        }

        @keyframes pulse {
            0% {
                opacity: 0.3;
            }

            100% {
                opacity: 0.6;
            }
        }

        .wrap {
            width: min(1100px, 100%);
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 32px;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 900px) {
            .wrap {
                grid-template-columns: 1fr;
                max-width: 480px;
            }

            .hero {
                order: 2;
            }
        }

        /* Hero Section */
        .hero {
            border: 1px solid rgba(251, 191, 36, 0.3);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.6) 0%, rgba(255, 237, 213, 0.5) 100%);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 20px 60px rgba(217, 119, 6, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -150px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(251, 191, 36, 0.25), transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.2), transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, 20px);
            }
        }

        .hero h1 {
            margin: 0 0 16px 0;
            font-size: 36px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }

        .hero p {
            margin: 0 0 24px 0;
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 15px;
            position: relative;
            z-index: 1;
        }

        /* 卡片 */
        .card {
            border: 1px solid var(--card-border);
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow:
                0 25px 70px rgba(217, 119, 6, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card h2 {
            margin: 0 0 28px 0;
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* 表單字段 */
        .field {
            margin: 24px 0;
        }

        label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
            color: var(--text-secondary);
        }

        .req {
            color: var(--danger);
            font-weight: 600;
            font-size: 11px;
            background: var(--danger-bg);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .hint {
            margin-left: auto;
            color: var(--text-muted);
            font-size: 12px;
        }

        .control {
            display: flex;
            gap: 10px;
            align-items: stretch;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            backdrop-filter: blur(10px);
            color: var(--text-primary);
            outline: none;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: var(--text-muted);
            opacity: 0.6;
        }

        input:focus {
            border-color: var(--accent-orange);
            background: rgba(255, 255, 255, 0.9);
            box-shadow:
                0 0 0 4px var(--focus-ring),
                0 4px 12px rgba(249, 115, 22, 0.2);
            transform: translateY(-1px);
        }

        input:hover:not(:focus) {
            border-color: rgba(251, 191, 36, 0.6);
        }

        /* 按鈕 */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            backdrop-filter: blur(10px);
            color: var(--text-secondary);
            cursor: pointer;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn:hover {
            border-color: rgba(251, 191, 36, 0.8);
            background: rgba(255, 251, 235, 0.9);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn.primary {
            width: 100%;
            border: none;
            background: linear-gradient(135deg, var(--accent-orange) 0%, var(--accent-orange-dark) 100%);
            color: white;
            font-weight: 600;
            font-size: 15px;
            padding: 15px 24px;
            box-shadow:
                0 4px 16px rgba(249, 115, 22, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .btn.primary:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            box-shadow:
                0 6px 20px rgba(249, 115, 22, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .btn.primary:active {
            transform: translateY(0);
        }

        /* 行動 */
        .actions {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .row {
            display: flex;
            gap: 12px;
            justify-content: space-between;
            align-items: center;
            color: var(--text-muted);
            font-size: 13px;
        }

        .row a {
            color: var(--accent-orange);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .row a:hover {
            color: var(--accent-orange-dark);
            text-decoration: underline;
        }

        /* 複選框 */
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--accent-orange);
        }

        /* 錯誤訊息 */
        .error {
            margin-top: 16px;
            padding: 16px 18px;
            border-radius: 12px;
            border: 1px solid rgba(127, 29, 29, 0.5);
            background: var(--danger-bg);
            backdrop-filter: blur(10px);
            color: #fecaca;
            font-size: 13px;
            line-height: 1.7;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            75% {
                transform: translateX(8px);
            }
        }

        .error b {
            color: #fca5a5;
            font-weight: 600;
        }

        .error ul {
            margin: 10px 0 0 20px;
            padding: 0;
        }

        .error li {
            margin: 4px 0;
        }

        .input-error {
            border-color: var(--danger) !important;
            background: rgba(127, 29, 29, 0.1) !important;
            box-shadow:
                0 0 0 4px rgba(239, 68, 68, 0.2) !important,
                0 4px 12px rgba(239, 68, 68, 0.15) !important;
        }

        /* 小文字 */
        .small {
            color: var(--text-muted);
            font-size: 12px;
            margin-top: 8px;
            line-height: 1.6;
        }

        .small code {
            background: rgba(251, 191, 36, 0.2);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 11px;
            color: var(--accent-orange-dark);
        }

        /* 驗證碼 */
        .captchaBox {
            display: flex;
            gap: 12px;
            align-items: stretch;
            width: 100%;
        }

        .captchaBox input {
            flex: 1;
        }

        .captchaBox img {
            height: 48px;
            width: auto;
            border-radius: 12px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            display: block;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(217, 119, 6, 0.1);
        }

        .captchaBox img:hover {
            border-color: var(--accent-orange);
            transform: scale(1.05);
            box-shadow:
                0 4px 16px rgba(249, 115, 22, 0.3),
                0 0 0 4px var(--focus-ring);
        }

        .captchaBox img:active {
            transform: scale(0.98);
        }

        /* 反應靈敏 */
        @media (max-width: 900px) {
            .hero {
                padding: 32px 28px;
            }

            .hero h1 {
                font-size: 28px;
            }

            .card {
                padding: 32px 28px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 20px 16px;
            }

            .hero,
            .card {
                padding: 24px 20px;
            }

            .hero h1 {
                font-size: 24px;
            }

            .card h2 {
                font-size: 20px;
            }

            input[type="text"],
            input[type="password"] {
                padding: 12px 14px;
                font-size: 14px;
            }

            .btn.primary {
                padding: 13px 20px;
            }
        }

        /* 載入動畫 */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn.primary.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            display: inline-block;
            margin-left: 8px;
            animation: spin 0.6s linear infinite;
        }
    </style>
</head>

<body>
    <main class="wrap">
        <section class="hero" aria-hidden="true">
            <h1>🔐 管理登入</h1>
            <p>請輸入您的帳號、密碼與圖形驗證碼以完成登入。系統將驗證您的身份資訊並導向管理後台。</p>
            <div class="small" style="margin-top:16px;">
                💡 <strong>開發提示：</strong>範例帳密來源為 .env 檔案中的 <code>ADMIN_USERID</code> 與 <code>ADMIN_PASSWORD</code> 設定值。
            </div>
        </section>

        <section class="card">
            <h2>會員登入</h2>

            <form id="loginForm" action="{{ route('admin.login.post') }}" method="post" novalidate>
                @csrf

                {{-- ✅ 失敗提示：帳密錯誤 --}}
                @if ($errors->has('login'))
                    <div class="error" role="alert" aria-live="polite">
                        <b>⚠️ {{ $errors->first('login') }}</b>
                    </div>
                @endif

                {{-- 其他欄位驗證錯誤總覽 --}}
                @if ($errors->any() && !$errors->has('login'))
                    <div class="error" role="alert" aria-live="polite">
                        <div><b>⚠️ 資料有誤，請修正後再送出：</b></div>
                        <ul>
                            @foreach ($errors->all() as $msg)
                                <li>{{ $msg }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- 前端必填檢查用錯誤盒 --}}
                <div id="frontErrorBox" class="error" style="display:none;" role="alert" aria-live="polite"></div>

                <div class="field">
                    <label for="userId">
                        帳號
                        <span class="req">*必填</span>
                    </label>
                    <div class="control">
                        <input id="userId" name="userId" type="text" placeholder="請輸入您的帳號"
                            value="{{ old('userId') }}" autocomplete="username" />
                    </div>
                </div>

                <div class="field">
                    <label for="pwd">
                        密碼
                        <span class="req">*必填</span>
                    </label>
                    <div class="control">
                        <input id="pwd" name="pwd" type="password" placeholder="請輸入您的密碼"
                            autocomplete="current-password" />
                        <button type="button" class="btn" id="togglePwd" aria-label="切換密碼顯示">👁️ 顯示</button>
                    </div>
                </div>

                <div class="field">
                    <label for="code">
                        圖形驗證碼
                        <span class="req">*必填</span>
                        <span class="hint">👆 點圖片可換一張</span>
                    </label>

                    <div class="control captchaBox">
                        <input id="code" name="code" type="text" placeholder="請輸入圖形驗證碼" autocomplete="off"
                            maxlength="6" />
                        <span id="captcha-img" title="點擊可重新產生驗證碼">
                            {!! captcha_img('default') !!}
                        </span>
                    </div>

                    <div class="small">🔄 驗證碼錯誤會自動提示，點擊圖片可立即刷新。</div>
                </div>

                <div class="actions">
                    <button class="btn primary" type="submit">🚀 立即登入</button>

                    <div class="row">
                        <label style="display:flex; gap:8px; align-items:center; margin:0; cursor:pointer;">
                            <input type="checkbox" name="remember" value="1"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span>記住我（30 天）</span>
                        </label>

                        <span class="small">✅ 登入成功後進入 /admin</span>
                    </div>

                    <div class="row">
                        <a href="{{ route('admin.forgot') }}">🔑 忘記密碼？</a>
                        <a href="{{ route('admin.register') }}">📝 註冊新帳號</a>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            const $form = $('#loginForm');
            const $frontErrorBox = $('#frontErrorBox');
            const $userId = $('#userId');
            const $pwd = $('#pwd');
            const $code = $('#code');
            const $togglePwd = $('#togglePwd');
            const $captchaImgWrap = $('#captcha-img');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const $submitBtn = $form.find('.btn.primary');

            // 設定錯誤狀態
            function setError($el, isError) {
                $el.toggleClass('input-error', !!isError);
                if (isError) {
                    $el.attr('aria-invalid', 'true');
                } else {
                    $el.removeAttr('aria-invalid');
                }
            }

            // 顯示前端錯誤訊息
            function showFrontErrors(messages) {
                if (!messages.length) {
                    $frontErrorBox.hide().html('');
                    return;
                }
                const errorHtml = `
          <div><b>⚠️ 請先完成以下必填欄位：</b></div>
          <ul>${messages.map(m => `<li>${m}</li>`).join('')}</ul>
        `;
                $frontErrorBox.html(errorHtml).show();
            }

            // 密碼顯示/隱藏切換
            $togglePwd.on('click', function() {
                const isPwd = $pwd.attr('type') === 'password';
                $pwd.attr('type', isPwd ? 'text' : 'password');
                $(this).html(isPwd ? '🙈 隱藏' : '👁️ 顯示');
            });

            // 刷新驗證碼
            function refreshCaptcha() {
                $.ajax({
                    url: '{{ route('captcha.refresh') }}',
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        ...(csrfToken ? {
                            'X-CSRF-TOKEN': csrfToken
                        } : {})
                    },
                    success: function(data) {
                        $captchaImgWrap.html(data.captcha);
                        $code.val('');
                        setError($code, false);
                    },
                    error: function() {
                        alert('❌ 刷新驗證碼失敗，請確認 /captcha-refresh 路由是否存在');
                    }
                });
            }

            $captchaImgWrap.on('click', 'img', refreshCaptcha);

            // ===== 驗證碼不分大小寫：前端統一轉小寫 =====
            function normalizeCaptchaInput() {
                const v = ($.trim($code.val()) || '');
                $code.val(v.toLowerCase());
            }

            // 使用者輸入時就即時轉換（避免看起來有大小寫差）
            $code.on('input', normalizeCaptchaInput);


            // 表單提交驗證
            $form.on('submit', function(e) {
                e.preventDefault();
                // 送出前再保險轉一次
                normalizeCaptchaInput();

                const messages = [];
                const $fields = [$userId, $pwd, $code];

                // 清除所有錯誤狀態
                $fields.forEach($el => setError($el, false));
                showFrontErrors([]);

                // 驗證帳號
                if (!$.trim($userId.val())) {
                    messages.push('帳號（userId）尚未輸入');
                    setError($userId, true);
                }

                // 驗證密碼
                if (!$.trim($pwd.val())) {
                    messages.push('密碼（pwd）尚未輸入');
                    setError($pwd, true);
                }

                // 驗證驗證碼
                if (!$.trim($code.val())) {
                    messages.push('圖形驗證碼（code）尚未輸入');
                    setError($code, true);
                }

                // 如果有錯誤，顯示錯誤訊息並聚焦
                if (messages.length) {
                    showFrontErrors(messages);
                    const $firstError = $fields.find(el => el.hasClass('input-error'));
                    if ($firstError) $firstError.focus();
                } else {
                    // 驗證通過，顯示載入狀態並提交表單
                    $submitBtn.addClass('loading').prop('disabled', true);
                    this.submit();
                }
            });

            // 即時驗證 - input 事件
            const $allInputs = [$userId, $pwd, $code];
            $allInputs.forEach($el => {
                $el.on('input', function() {
                    setError($(this), false);
                    if ($frontErrorBox.is(':visible')) {
                        showFrontErrors([]);
                    }
                });

                $el.on('blur', function() {
                    if ($.trim($(this).val())) {
                        setError($(this), false);
                    }
                });
            });

            // 自動聚焦到第一個空白欄位
            $(window).on('load', function() {
                if (!$.trim($userId.val())) {
                    $userId.focus();
                } else if (!$.trim($pwd.val())) {
                    $pwd.focus();
                } else if (!$.trim($code.val())) {
                    $code.focus();
                }
            });
        });
    </script>
</body>

</html>
