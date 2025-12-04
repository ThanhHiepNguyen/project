<?php
// Chỉ cho phép chủ shop tạo thành viên
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] !== 'chu_shop') {
    die('Bạn không có quyền tạo thành viên mới.');
}

require "../cauhinh/ketnoi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mat_khau = $_POST['mat_khau'];
    
    // Thành viên mới mặc định là nhân viên
    $sql = "INSERT INTO thanhvien (email, mat_khau, vai_tro) VALUES ('$email', '$mat_khau', 'nhan_vien')";
    mysqli_query($conn, $sql);
    header("Location: quantri.php?page_layout=thanhvien");
    exit();
}
?>
<link rel="stylesheet" type="text/css" href="css/them_sua_tv.css" />
<form method="POST" action="them_thanhvien.php">
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Password:</label>
    <!-- <input type="password" name="mat_khau" required> -->
    <input type="text" name="mat_khau" required>
    <button type="submit">Thêm thành viên</button>
</form>
