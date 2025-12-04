<?php
session_start();
require_once __DIR__ . '/../../cauhinh/ketnoi.php';

$id_sp = isset($_GET['id_sp']) ? (int)$_GET['id_sp'] : 0;
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '../../index.php';

if ($id_sp <= 0) {
    header("Location: $redirect");
    exit;
}

// Yêu cầu đăng nhập khách hàng
if (!isset($_SESSION['khachhang'])) {
    header("Location: ../../index.php?page_layout=dangnhap");
    exit;
}

$id_khachhang = (int)$_SESSION['khachhang']['id_khachhang'];

// Kiểm tra đã có trong yêu thích chưa
$sql_check = "SELECT id_yeu_thich FROM yeu_thich WHERE id_khachhang = $id_khachhang AND id_sanpham = $id_sp LIMIT 1";
$res_check = mysqli_query($conn, $sql_check);

if ($res_check && mysqli_num_rows($res_check) > 0) {
    // Đã có -> bỏ yêu thích
    $row = mysqli_fetch_assoc($res_check);
    $id_yeu_thich = (int)$row['id_yeu_thich'];
    mysqli_query($conn, "DELETE FROM yeu_thich WHERE id_yeu_thich = $id_yeu_thich");
} else {
    // Chưa có -> thêm mới
    mysqli_query($conn, "INSERT INTO yeu_thich (id_khachhang, id_sanpham) VALUES ($id_khachhang, $id_sp)");
}

header("Location: $redirect");
exit;


