<?php
// Không cần session_start() vì index.php đã gọi rồi
// Kiểm tra nếu chưa đăng nhập thì đuổi về trang đăng nhập
if (!isset($_SESSION['khachhang'])) {
    echo '<script>
        alert("Bạn cần đăng nhập để xem lịch sử đơn hàng.");
        window.location.href = "index.php?page_layout=dangnhap";
    </script>';
    return;
}

$id_khachhang = $_SESSION['khachhang']['id_khachhang'];

// Truy vấn danh sách đơn hàng của khách
// Lưu ý: Đảm bảo tên bảng 'donhang' và cột 'id_khachhang' khớp với CSDL của bạn
$sql_donhang = "SELECT * FROM donhang WHERE id_khachhang = '$id_khachhang' ORDER BY id_donhang DESC";
$rs_donhang = mysqli_query($conn, $sql_donhang);
?>

<div class="container mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Đơn hàng của tôi</h2>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Mã đơn
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Ngày đặt
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Tổng tiền
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Trạng thái
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Chi tiết
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($rs_donhang) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($rs_donhang)): ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">#<?php echo $row['id_donhang']; ?></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <?php echo $row['ngay_dat']; ?> 
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap font-bold text-blue-600">
                                    <?php echo number_format($row['tong_gia'], 0, ',', '.'); ?>₫
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold leading-tight">
                                    <?php 
                                        $status = $row['trang_thai'];
                                        $statusClass = 'bg-gray-200 text-gray-900';
                                        if ($status === 'Chờ giao hàng') {
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                        } elseif ($status === 'Đang giao hàng') {
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                        } elseif ($status === 'Đã thanh toán') {
                                            $statusClass = 'bg-green-100 text-green-800';
                                        }
                                    ?>
                                    <span aria-hidden class="absolute inset-0 <?php echo $statusClass; ?> opacity-50 rounded-full"></span>
                                    <span class="relative <?php echo $statusClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="index.php?page_layout=chitietdonhang&id_donhang=<?php echo $row['id_donhang']; ?>" class="text-blue-600 hover:text-blue-900">
                                    Xem
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-5 py-5 bg-white text-sm text-center text-gray-500">
                            Bạn chưa có đơn hàng nào. <a href="index.php" class="text-blue-500">Mua sắm ngay</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>