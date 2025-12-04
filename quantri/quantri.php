<?php
session_start();
require "../cauhinh/ketnoi.php";

// Xác định vai trò hiện tại
$currentRole = isset($_SESSION['vai_tro']) ? $_SESSION['vai_tro'] : 'nhan_vien';
$isChuShop   = ($currentRole === 'chu_shop');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Shop Thu Minh - Quản trị</title>
    <link rel="stylesheet" type="text/css" href="css/quantri.css" />
    <script type="text/javascript">
        function confirmLogout() {
            return confirm("Bạn có muốn đăng xuất không?");
        }
    </script>
</head>

<body>
    <div id="header">
        <a href="#"><img src="anh/logo.png" /></a>
        <div id="navbar">
            <ul>
                <li id="admin-home"><a href="quantri.php?page_layout=trangchu">Trang chủ</a></li>
                <?php if ($isChuShop): ?>
                    <li><a href="quantri.php?page_layout=thanhvien">Thành viên</a></li>
                <?php endif; ?>
                <li><a href="quantri.php?page_layout=danhmucsp">Danh mục</a></li>
                <li><a href="quantri.php?page_layout=danhsachsp">Sản phẩm</a></li>
                <li><a href="quantri.php?page_layout=khachhang">Khách hàng</a></li>
                <li><a href="quantri.php?page_layout=quanlydonhang">Quản lý đơn hàng</a></li>
            </ul>
            <div id="user-info">
                <p>
                    <span><?php echo $_SESSION['tk']; ?></span>
                </p>
                <p><a href="dangxuat.php" onclick="return confirmLogout();">Đăng xuất</a></p>
            </div>
        </div>
    </div>
    <div id="body">
        <?php
        if (isset($_GET['page_layout'])) {
            switch ($_GET['page_layout']) {
                case 'trangchu':
                    include_once('trangchu.php');
                    break;
                case 'themsp':
                    include_once('themsp.php');
                    break;
                case 'suasp':
                    include_once('suasp.php');
                    break;
                case 'danhsachsp':
                    include_once('danhsachsp.php');
                    break;
                case 'danhmucsp':
                    include_once('danhmucsp.php');
                    break;
                case 'thanhvien':
                    if ($isChuShop) {
                        include_once('thanhvien.php');
                    } else {
                        echo "<p style=\"color:red; font-weight:bold;\">Bạn không có quyền truy cập chức năng quản lý thành viên.</p>";
                    }
                    break;
                case 'quanlydonhang':
                    include_once('quanlydonhang.php');
                    break;
                case 'chitietdonhang':
                    include_once('chitietdonhang.php');
                    break;
                case 'them_danhmuc':
                    include_once('them_danhmuc.php');
                    break;
                case 'sua_danhmuc':
                    include_once('sua_danhmuc.php');
                    break;
                case 'them_thanhvien':
                    if ($isChuShop) {
                        include_once('them_thanhvien.php');
                    } else {
                        echo "<p style=\"color:red; font-weight:bold;\">Bạn không có quyền thêm thành viên.</p>";
                    }
                    break;
                case 'sua_thanhvien':
                    if ($isChuShop) {
                        include_once('sua_thanhvien.php');
                    } else {
                        echo "<p style=\"color:red; font-weight:bold;\">Bạn không có quyền sửa thành viên.</p>";
                    }
                    break;
                case 'khachhang':
                    include_once('khachhang.php');
                    break;
                case 'sua_khachhang':
                    include_once('sua_khachhang.php');
                    break;
            }
        } else {
            // Trang chủ mặc định: thống kê admin
            include_once('trangchu.php');
        }
        ?>

    </div>
</body>

</html>