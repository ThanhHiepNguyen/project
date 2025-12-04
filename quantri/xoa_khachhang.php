<?php
if (!isset($_SESSION)) {
    session_start();
}
require "../cauhinh/ketnoi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM khachhang WHERE id_khachhang = $id");
}

header("Location: quantri.php?page_layout=khachhang");
exit;


