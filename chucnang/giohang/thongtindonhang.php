<?php
if (isset($_POST['search'])) {
    $phone = $_POST['phone'];
    require "cauhinh/ketnoi.php";

    if (!$conn) {
        die("Kết nối không thành công: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM donhang WHERE so_dien_thoai = '$phone'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">';
        echo '<h3 class="text-2xl font-bold text-gray-800 mb-6">Thông tin đơn hàng</h3>';
        echo '<div class="bg-white rounded-lg shadow-md overflow-hidden">';
        echo '<div class="overflow-x-auto">';
        echo '<table class="w-full">';
        echo '<thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">';
        echo '<tr>';
        echo '<th class="px-6 py-4 text-left font-semibold">ID Đơn Hàng</th>';
        echo '<th class="px-6 py-4 text-left font-semibold">Tên Khách Hàng</th>';
        echo '<th class="px-6 py-4 text-left font-semibold">Email</th>';
        echo '<th class="px-6 py-4 text-left font-semibold">Số Điện Thoại</th>';
        echo '<th class="px-6 py-4 text-left font-semibold">Địa Chỉ</th>';
        echo '<th class="px-6 py-4 text-right font-semibold">Tổng Giá</th>';
        echo '<th class="px-6 py-4 text-left font-semibold">Ngày Đặt</th>';
        echo '<th class="px-6 py-4 text-left font-semibold">Trạng Thái</th>';
        echo '<th class="px-6 py-4 text-center font-semibold">Chi Tiết</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody class="divide-y divide-gray-200">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr class="hover:bg-gray-50 transition-colors duration-200">';
            echo '<td class="px-6 py-4 text-gray-800">' . $row['id_donhang'] . '</td>';
            echo '<td class="px-6 py-4 text-gray-800">' . htmlspecialchars($row['ten_khachhang']) . '</td>';
            echo '<td class="px-6 py-4 text-gray-600">' . htmlspecialchars($row['email']) . '</td>';
            echo '<td class="px-6 py-4 text-gray-600">' . htmlspecialchars($row['so_dien_thoai']) . '</td>';
            echo '<td class="px-6 py-4 text-gray-600">' . htmlspecialchars($row['dia_chi']) . '</td>';
            echo '<td class="px-6 py-4 text-right font-bold text-blue-600">' . number_format($row['tong_gia'], 0, ',', '.') . '₫</td>';
            echo '<td class="px-6 py-4 text-gray-600">' . $row['ngay_dat'] . '</td>';
            echo '<td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">' . htmlspecialchars($row['trang_thai']) . '</span></td>';
            echo '<td class="px-6 py-4 text-center"><a class="text-blue-600 hover:text-blue-700 font-semibold underline transition-colors duration-200" href="index.php?page_layout=chitietdonhang&id_donhang=' . $row['id_donhang'] . '">Xem chi tiết</a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">';
        echo '<div class="bg-white rounded-lg shadow-md p-8">';
        echo '<i class="fa-solid fa-inbox text-6xl text-gray-400 mb-4"></i>';
        echo '<p class="text-xl text-gray-600 font-semibold">Không tìm thấy đơn hàng với số điện thoại này.</p>';
        echo '<a href="index.php?page_layout=lichsudonhang" class="mt-6 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">Tra cứu lại</a>';
        echo '</div>';
        echo '</div>';
    }
    mysqli_close($conn);
}
?>
