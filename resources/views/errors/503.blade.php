<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Dịch vụ không khả dụng</title>
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
            max-width: 500px;
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
            margin-bottom: 24px;
            max-width: 360px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .status-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 28px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .status-info i {
            font-size: 16px;
        }
        
        .countdown-container {
            margin: 20px 0 28px;
            padding: 16px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        
        .countdown-label {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .countdown {
            font-size: 24px;
            font-weight: 600;
            color: #4a5568;
            font-family: monospace;
        }
        
        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 8px;
        }
        
        .button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #4a5568;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 500;
            transition: background-color 0.2s ease;
            border: none;
            cursor: pointer;
            min-width: 140px;
            justify-content: center;
        }
        
        .button:hover {
            background-color: #2d3748;
        }
        
        .button-secondary {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .button-secondary:hover {
            background-color: #dee2e6;
        }
        
        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 28px 0;
            max-width: 240px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .help-text {
            color: #868e96;
            font-size: 13px;
            margin-top: 20px;
        }
        
        .help-text a {
            color: #4a5568;
            text-decoration: none;
        }
        
        .help-text a:hover {
            text-decoration: underline;
        }
        
        .maintenance-details {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 12px;
            margin-top: 16px;
            font-size: 13px;
            color: #6c757d;
            text-align: left;
            border: 1px solid #e9ecef;
            text-align: center;
        }
        
        .progress-container {
            width: 100%;
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            margin-top: 12px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background-color: #4a5568;
            width: 30%;
            border-radius: 3px;
            animation: progressPulse 2s infinite ease-in-out;
        }
        
        @keyframes progressPulse {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
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
            
            .actions {
                flex-direction: column;
                align-items: center;
            }
            
            .button {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="error-code">503</div>
        
        <h1 class="error-title">Dịch vụ tạm thời không khả dụng</h1>
        
        <p class="error-description">
            Hệ thống đang được bảo trì hoặc tạm quá tải. Vui lòng truy cập lại sau vài phút.
        </p>
        
        <div class="status-info">
            <i class="fas fa-tools"></i>
            Đang tiến hành bảo trì hệ thống
        </div>
        
        <div class="countdown-container">
            <div class="countdown-label">Dự kiến hoạt động trở lại sau:</div>
            <div class="countdown" id="countdown">30:00</div>
            <div class="progress-container">
                <div class="progress-bar"></div>
            </div>
        </div>
        
        <div class="actions">
            <a href="{{ route('cpanel.dashboard') }}" class="button">
                <i class="fas fa-home"></i>
                Về Dashboard
            </a>
            
            <button onclick="window.location.reload()" class="button button-secondary">
                <i class="fas fa-redo"></i>
                Thử lại ngay
            </button>
        </div>
        
        <div class="divider"></div>
        
        <div class="help-text">
            <p>Trong thời gian chờ đợi, bạn có thể:</p>
            <ul style="margin: 8px 0 12px 20px; text-align: left;">
                <li>Truy cập lại sau 15-30 phút</li>
                <li>Kiểm tra thông báo từ quản trị viên</li>
                <li>Thực hiện công việc khác và quay lại sau</li>
            </ul>
            
            <div class="maintenance-details">
                <p><i class="fas fa-clock"></i> Bắt đầu bảo trì: <span id="maintenance-start"></span></p>
                <p><i class="fas fa-history"></i> Thời lượng dự kiến: 30 phút</p>
            </div>
            
            <p style="margin-top: 16px;">Cần hỗ trợ khẩn cấp? <a href="mailto:support@example.com">Liên hệ ngay</a></p>
            <p style="margin-top: 8px;">Thời gian hiện tại: <span id="current-time"></span></p>
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
            
            // Hiển thị thời gian bắt đầu bảo trì (30 phút trước)
            const maintenanceStart = new Date(now.getTime() - 30 * 60000);
            const startTimeString = maintenanceStart.toLocaleTimeString('vi-VN', options);
            document.getElementById('maintenance-start').textContent = `${startTimeString}`;
        }
        
        // Đếm ngược thời gian
        let countdownSeconds = 30 * 60; // 30 phút
        
        function updateCountdown() {
            const minutes = Math.floor(countdownSeconds / 60);
            const seconds = countdownSeconds % 60;
            
            document.getElementById('countdown').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Cập nhật progress bar
            const progressBar = document.querySelector('.progress-bar');
            const progressPercent = (1 - (countdownSeconds / (30 * 60))) * 100;
            progressBar.style.width = `${progressPercent}%`;
            
            if (countdownSeconds > 0) {
                countdownSeconds--;
            } else {
                // Khi hết giờ, thay đổi thông báo
                document.querySelector('.status-info').innerHTML = 
                    '<i class="fas fa-check-circle"></i> Bảo trì đã hoàn tất, hệ thống đang khởi động lại';
                document.querySelector('.countdown-label').textContent = 'Hệ thống sẽ sẵn sàng trong giây lát...';
                document.getElementById('countdown').textContent = 'SẮP XONG';
                
                // Tự động thử reload sau 10 giây
                setTimeout(() => {
                    window.location.reload();
                }, 10000);
            }
        }
        
        // Khởi tạo
        updateTime();
        setInterval(updateTime, 1000);
        
        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);
        
        // Kiểm tra định kỳ nếu server đã hoạt động trở lại
        function checkServerStatus() {
            // Có thể thực hiện AJAX request nhẹ để kiểm tra
            fetch(window.location.href, { method: 'HEAD' })
                .then(response => {
                    if (response.status === 200) {
                        clearInterval(countdownInterval);
                        document.querySelector('.status-info').innerHTML = 
                            '<i class="fas fa-check-circle"></i> Hệ thống đã hoạt động trở lại!';
                        document.querySelector('.countdown-container').innerHTML = 
                            '<div style="color: #28a745; font-weight: 500;">Có thể truy cập ngay bây giờ</div>';
                        
                        // Tự động chuyển hướng sau 3 giây
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    }
                })
                .catch(() => {
                    // Server vẫn chưa hoạt động, tiếp tục chờ
                });
        }
        
        // Kiểm tra mỗi 30 giây
        setInterval(checkServerStatus, 30000);
        
        // Hiệu ứng nhẹ cho nút bấm
        const buttons = document.querySelectorAll('.button');
        
        buttons.forEach(button => {
            button.addEventListener('mousedown', () => {
                button.style.transform = 'scale(0.98)';
            });
            
            button.addEventListener('mouseup', () => {
                button.style.transform = 'scale(1)';
            });
            
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>