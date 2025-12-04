<?php
// Danh sách đơn hàng của tài khoản đang đăng nhập

if (!isset($_SESSION['khachhang'])) {
    ?>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Đơn hàng của tôi</h2>
            <p class="text-gray-600 mb-6">
                Vui lòng đăng nhập để xem lịch sử đơn hàng của bạn.
            </p>
            <a href="index.php?page_layout=dangnhap"
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow">
                <i class="fa-solid fa-right-to-bracket mr-2"></i> Đăng nhập
            </a>
        </div>
    </div>
    <?php
    return;
}

$id_khachhang = (int)$_SESSION['khachhang']['id_khachhang'];

$sql = "
    SELECT *
    FROM donhang
    WHERE id_khachhang = $id_khachhang
    ORDER BY ngay_dat DESC, id_donhang DESC
";
$result = mysqli_query($conn, $sql);
?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                Đơn hàng của tôi
            </h2>
            <span class="text-sm text-gray-500">
                Tài khoản: <span class="font-semibold">
                    <?php echo htmlspecialchars($_SESSION['khachhang']['email']); ?>
                </span>
            </span>
        </div>

        <?php if (!$result || mysqli_num_rows($result) === 0): ?>
            <div class="text-center py-10">
                <p class="text-gray-600 mb-4">
                    Bạn chưa có đơn hàng nào.
                </p>
                <a href="index.php"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow">
                    <i class="fa-solid fa-cart-shopping mr-2"></i> Mua sắm ngay
                </a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mã đơn
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ngày đặt
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tổng tiền
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trạng thái
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thanh toán
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Chi tiết
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                                    #<?php echo $row['id_donhang']; ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <?php echo date('d/m/Y H:i', strtotime($row['ngay_dat'])); ?>
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-right text-blue-600">
                                    <?php echo number_format($row['tong_gia'], 0, ',', '.'); ?>₫
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <?php
                                    $status = $row['trang_thai'];
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    if ($status === 'Chờ giao hàng') {
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                    } elseif ($status === 'Đang giao hàng') {
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif ($status === 'Đã thanh toán') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    }
                                    ?>
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold <?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <?php echo htmlspecialchars($row['phuong_thuc_thanh_toan']); ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="index.php?page_layout=chitietdonhang&id_donhang=<?php echo $row['id_donhang']; ?>"
                                       class="inline-flex items-center px-3 py-1 text-sm font-semibold text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-full transition-colors duration-150">
                                        Xem
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>


