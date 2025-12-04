<?php
// Đăng xuất khách hàng
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['khachhang'])) {
    unset($_SESSION['khachhang']);
}

// Không dùng header() vì có thể đã có output trước đó; dùng JavaScript để chuyển trang
echo '<script>window.location.href = "index.php";</script>';
exit;
