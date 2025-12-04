<?php
if (!isset($_SESSION)) {
    session_start();
}
require "../cauhinh/ketnoi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    // Kiểm tra xem khách hàng có đơn hàng hay chưa
    $sqlCheck = "SELECT COUNT(*) AS total FROM donhang WHERE id_khachhang = $id";
    $resultCheck = mysqli_query($conn, $sqlCheck);
    $rowCheck = $resultCheck ? mysqli_fetch_assoc($resultCheck) : ['total' => 0];

    if ($rowCheck['total'] > 0) {
        // Nếu đã có đơn hàng, không cho xóa và lưu thông báo vào session
        $_SESSION['error_khachhang'] = "Khách hàng đã có đơn hàng, không thể xóa.";
    } else {
        // Không có đơn hàng, cho phép xóa
        mysqli_query($conn, "DELETE FROM khachhang WHERE id_khachhang = $id");
        $_SESSION['success_khachhang'] = "Xóa khách hàng thành công.";
    }
}

header("Location: quantri.php?page_layout=khachhang");
exit;


