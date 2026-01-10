<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 480px;
            width: 100%;
            text-align: center;
            padding: 40px 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
        }
        
        .error-code {
            font-size: 64px;
            font-weight: 300;
            color: #495057;
            margin-bottom: 16px;
            letter-spacing: 2px;
        }
        
        .error-title {
            font-size: 20px;
            font-weight: 500;
            color: #212529;
            margin-bottom: 16px;
        }
        
        .error-description {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 32px;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .back-button {
            display: inline-block;
            background-color: #4a5568;
            color: white;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            transition: background-color 0.2s ease;
            border: none;
            cursor: pointer;
        }
        
        .back-button:hover {
            background-color: #2d3748;
        }
        
        .back-button i {
            margin-right: 8px;
        }
        
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 32px 0;
            max-width: 240px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .help-text {
            color: #868e96;
            font-size: 13px;
            margin-top: 24px;
        }
        
        .help-text a {
            color: #4a5568;
            text-decoration: none;
        }
        
        .help-text a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            .error-code {
                font-size: 56px;
            }
            
            .error-title {
                font-size: 18px;
            }
            
            .error-description {
                font-size: 14px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        
        <h1 class="error-title">Trang không tìm thấy</h1>
        
        <p class="error-description">
            Trang bạn đang tìm kiếm có thể đã bị xóa, đổi tên hoặc tạm thời không khả dụng.
        </p>
        
        <a href="{{ route('cpanel.dashboard') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Về Dashboard
        </a>
        
        <div class="divider"></div>
        
        <div class="help-text">
            <p>Nếu bạn tin đây là lỗi, vui lòng <a href="mailto:support@example.com">liên hệ hỗ trợ</a></p>
            <p style="margin-top: 8px;">Thời gian: <span id="current-time"></span></p>
        </div>
    </div>

    <script>
        // Hiển thị thời gian hiện tại
        function updateTime() {
            const now = new Date();
            const options = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            const timeString = now.toLocaleTimeString('vi-VN', options);
            const dateString = now.toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            
            document.getElementById('current-time').textContent = `${timeString} ${dateString}`;
        }
        
        updateTime();
        setInterval(updateTime, 1000);
        
        // Hiệu ứng nhẹ cho nút bấm
        const button = document.querySelector('.back-button');
        
        button.addEventListener('mousedown', () => {
            button.style.transform = 'scale(0.98)';
        });
        
        button.addEventListener('mouseup', () => {
            button.style.transform = 'scale(1)';
        });
        
        button.addEventListener('mouseleave', () => {
            button.style.transform = 'scale(1)';
        });
    </script>
</body>
</html>