<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "cauhinh/ketnoi.php";

$id_donhang = isset($_GET['id_donhang']) ? (int)$_GET['id_donhang'] : 0;
$order = null;
$details = [];

if ($id_donhang > 0 && $conn) {
    // Lấy thông tin đơn hàng
    $sql_order = "SELECT * FROM donhang WHERE id_donhang = $id_donhang LIMIT 1";
    $rs_order = mysqli_query($conn, $sql_order);
    if ($rs_order && mysqli_num_rows($rs_order) === 1) {
        $order = mysqli_fetch_assoc($rs_order);
    }

    // Lấy chi tiết đơn hàng + hình sản phẩm
    $sql_details = "
        SELECT cd.*, s.anh_sp 
        FROM chitiet_donhang AS cd
        LEFT JOIN sanpham AS s ON cd.id_sanpham = s.id_sp
        WHERE cd.id_donhang = $id_donhang
    ";
    $result_details = mysqli_query($conn, $sql_details);
    if ($result_details) {
        while ($row = mysqli_fetch_assoc($result_details)) {
            $details[] = $row;
        }
    }
}
?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <?php if (!$order): ?>
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <p class="text-lg text-gray-600 font-semibold">Không tìm thấy đơn hàng.</p>
            <a href="index.php?page_layout=donhangcuatoi"
               class="mt-4 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200">
                Quay lại đơn hàng của tôi
            </a>
        </div>
    <?php else: ?>
        <!-- Thông tin chung đơn hàng -->
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">
                        Chi tiết đơn hàng #<?php echo $order['id_donhang']; ?>
                    </h2>
                    <p class="text-sm text-gray-600">
                        Ngày đặt:
                        <span class="font-semibold">
                            <?php echo htmlspecialchars($order['ngay_dat']); ?>
                        </span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Tên khách hàng:
                        <span class="font-semibold">
                            <?php echo htmlspecialchars($order['ten_khachhang']); ?>
                        </span>
                    </p>
                    <p class="text-sm text-gray-600">
                        Địa chỉ:
                        <span class="font-semibold">
                            <?php echo htmlspecialchars($order['dia_chi']); ?>
                        </span>
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Trạng thái</p>
                    <?php
                    $status = $order['trang_thai'] ?? '';
                    $statusClass = 'bg-gray-100 text-gray-800';
                    if ($status === 'Chờ giao hàng') {
                        $statusClass = 'bg-yellow-100 text-yellow-800';
                    } elseif ($status === 'Đang giao hàng') {
                        $statusClass = 'bg-blue-100 text-blue-800';
                    } elseif ($status === 'Đã thanh toán') {
                        $statusClass = 'bg-green-100 text-green-800';
                    }
                    ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?php echo $statusClass; ?>">
                        <?php echo htmlspecialchars($status); ?>
                    </span>

                    <p class="mt-4 text-sm text-gray-500">Tổng giá trị đơn hàng</p>
                    <p class="text-xl font-bold text-blue-600">
                        <?php echo number_format($order['tong_gia'], 0, ',', '.'); ?>₫
                    </p>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết sản phẩm -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Sản Phẩm</th>
                            <th class="px-6 py-4 text-center font-semibold">Giá</th>
                            <th class="px-6 py-4 text-center font-semibold">Số Lượng</th>
                            <th class="px-6 py-4 text-right font-semibold">Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (count($details) === 0): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Không có chi tiết đơn hàng.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($details as $detail): ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <?php if (!empty($detail['anh_sp'])): ?>
                                                <img src="<?php echo htmlspecialchars($detail['anh_sp']); ?>"
                                                     alt="<?php echo htmlspecialchars($detail['ten_sanpham']); ?>"
                                                     class="w-16 h-16 rounded-md border object-cover" />
                                            <?php else: ?>
                                                <div class="w-16 h-16 rounded-md border bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                                                    No image
                                                </div>
                                            <?php endif; ?>
                                            <span class="font-medium text-gray-800">
                                                <?php echo htmlspecialchars($detail['ten_sanpham']); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-600">
                                        <?php echo number_format($detail['gia'], 0, ',', '.'); ?>₫
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-600">
                                        <?php echo (int)$detail['so_luong']; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-blue-600">
                                        <?php echo number_format($detail['thanh_tien'], 0, ',', '.'); ?>₫
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center">
            <a href="index.php?page_layout=donhangcuatoi"
               class="inline-block px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-colors duration-200">
                Quay lại đơn hàng của tôi
            </a>
        </div>
    <?php endif; ?>
</div>


