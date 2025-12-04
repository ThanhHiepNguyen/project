
<?php
session_start();
require "cauhinh/ketnoi.php";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Thu Minh - Phụ tùng xe máy, xe ô tô chính hãng</title>
    <meta name="description" content="Shop Thu Minh - Chuyên cung cấp phụ tùng xe máy, xe ô tô chính hãng với chất lượng tốt nhất, giá cả hợp lý. Giao hàng nhanh, bảo hành uy tín.">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/7a44704f56.js" crossorigin="anonymous"></script>
    
    <!-- Custom CSS for specific components (only for pages that haven't been converted yet) -->
    <link rel="stylesheet" type="text/css" href="css/lienhe.css" />

</head>

<body class="bg-gray-50 font-sans antialiased">
    <!-- Header -->
    <?php include_once('header.php'); ?>
    <!-- End Header -->

    <!-- Banner -->
    <?php if (!isset($_GET['page_layout']) || in_array($_GET['page_layout'], ['home', ''])): ?>
        <div class="banner w-full">
            <?php require "banner1.php"; ?>
        </div>
    <?php endif; ?>

    <!--Main-->
    <div id="main" class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <?php
        if (isset($_GET['page_layout'])) {
            switch ($_GET['page_layout']) {
                case 'gioithieu':
                    require_once('chucnang/menungang/gioithieu.php');
                    break;
                case 'dichvu':
                    require_once('chucnang/menungang/dichvu.php');
                    break;
                case 'lienhe':
                    require_once('chucnang/menungang/lienhe.php');
                    break;
                case 'chitietsp':
                    require_once('chucnang/sanpham/chitietsp.php');
                    break;
                case 'danhsachsp':
                    require_once('chucnang/sanpham/danhsachsp.php');
                    break;
                case 'danhsachtimkiem':
                    require_once('chucnang/timkiem/danhsachtimkiem.php');
                    break;
                case 'giohang':
                    require_once('chucnang/giohang/giohang.php');
                    break;
                case 'muahang':
                    require_once('chucnang/giohang/muahang.php');
                    break;
                case 'hoanthanh':
                    require_once('chucnang/giohang/hoanthanh.php');
                    break;
                case 'chitietdonhang':
                    require_once('chucnang/giohang/chitietdonhang.php');
                    break;
                case 'muahangtructiep':
                    require_once('chucnang/giohang/muahangtructiep.php');
                    break;
                case 'dangnhap':
                    require_once('chucnang/auth/dangnhap.php');
                    break;
                case 'dangky':
                    require_once('chucnang/auth/dangky.php');
                    break;
                case 'quenmatkhau':
                    require_once('chucnang/auth/quenmatkhau.php');
                    break;
                case 'donhangcuatoi':
                    require_once('chucnang/auth/donhangcuatoi.php');
                    break;
                case 'hoso':
                    require_once('chucnang/auth/hoso.php');
                    break;
                case 'yeuthich':
                    require_once('chucnang/yeuthich/danhsach.php');
                    break;
                case 'dangxuat':
                    require_once('chucnang/auth/dangxuat.php');
                    break;
                default:
                    require_once('chucnang/sanpham/sanphamdacbiet.php');
                    require_once('chucnang/sanpham/sanphamthinhhanh.php');
                    require_once('chucnang/sanpham/sanphammoi.php');
            }
        } else {

            require "chucnang/sanpham/sanphamdacbiet.php";
            require "chucnang/sanpham/sanphamthinhhanh.php";
            require "chucnang/sanpham/sanphammoi.php";
        }
        ?>
    </div>
    
    <!-- Footer -->
    <?php include_once('footer.php'); ?>
    <!-- End Footer -->
</body>
</html>