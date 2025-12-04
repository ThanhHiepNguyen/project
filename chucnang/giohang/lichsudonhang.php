<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Bắt buộc đăng nhập trước khi sử dụng chức năng tra cứu đơn hàng
if (!isset($_SESSION['khachhang'])) {
    header('Location: index.php?page_layout=dangnhap');
    exit;
}
?>

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8 pb-4 border-b-2 border-blue-600">
            Tra cứu đơn hàng
        </h2>
        <form method="post" action="index.php?page_layout=thongtindonhang" class="space-y-6">
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                    Số điện thoại <span class="text-red-500">*</span>
                </label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       required
                       placeholder="Nhập số điện thoại đã đặt hàng"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>
            <button type="submit" 
                    name="search" 
                    class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                <i class="fa-solid fa-search mr-2"></i>
                Tra cứu đơn hàng
            </button>
        </form>
    </div>
</div>
