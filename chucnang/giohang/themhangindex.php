<?php
session_start();

// Yêu cầu đăng nhập trước khi thêm sản phẩm vào giỏ hàng từ trang danh sách
if (!isset($_SESSION['khachhang'])) {
    header('Location: ../../index.php?page_layout=dangnhap');
    exit;
}

$id_sp = isset($_GET['id_sp']) ? (int)$_GET['id_sp'] : 0;
$quantity_to_add = 1; // Số lượng mặc định thêm vào giỏ hàng

if ($id_sp > 0) {
    // Nếu đã tồn tại sản phẩm trong giỏ hàng thì tăng số lượng lên 1 đơn vị. Ngược lại, số lượng được gán = 1
    if (isset($_SESSION['giohang'][$id_sp])) {
        $_SESSION['giohang'][$id_sp] += $quantity_to_add;
    } else {
        $_SESSION['giohang'][$id_sp] = $quantity_to_add;
    }
}

// Quay lại trang trước nếu có, không thì về trang chủ
if (!empty($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ../../index.php');
}
exit;
?>
