<div class="hidden md:block">
    <?php
    // Chuyển thẳng tới "Đơn hàng của tôi" nếu đã đăng nhập, ngược lại yêu cầu đăng nhập
    $href = isset($_SESSION['khachhang'])
        ? "index.php?page_layout=donhangcuatoi"
        : "index.php?page_layout=dangnhap";
    ?>
    <a href="<?php echo $href; ?>" 
       class="flex items-center px-3 py-2 border border-gray-300 rounded-lg bg-white hover:bg-blue-50 transition-all duration-200 shadow-sm hover:shadow-md group">
        <i class="fa-solid fa-truck text-lg text-blue-600 mr-2 group-hover:text-blue-700"></i>
        <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-600 whitespace-nowrap">
            Tra cứu đơn hàng
        </span>
    </a>
</div>
