<?php
session_start();

// Yêu cầu đăng nhập trước khi thêm sản phẩm vào giỏ hàng
if (!isset($_SESSION['khachhang'])) {
    header('Location: ../../index.php?page_layout=dangnhap');
    exit;
}

$id_sp = isset($_GET['id_sp']) ? (int)$_GET['id_sp'] : 0;
if ($id_sp <= 0) {
    header('Location: ../../index.php');
    exit;
}

// Nếu đã tồn tại sản phẩm trong giỏ hàng thì tăng sl lên 1 đơn vị. Ngược lại, số lượng được gán = 1
if (isset($_SESSION['giohang'][$id_sp])) {
    $_SESSION['giohang'][$id_sp] += 1;
} else {
    $_SESSION['giohang'][$id_sp] = 1;
}

header('Location: ../../index.php?page_layout=giohang');
exit;
?>