<?php
require "../cauhinh/ketnoi.php";

// Tổng số đơn hàng
$totalOrders = 0;
$resOrders = mysqli_query($conn, "SELECT COUNT(*) AS total FROM donhang");
if ($resOrders) {
    $totalOrders = (int)mysqli_fetch_assoc($resOrders)['total'];
}

// Tổng doanh thu đã thanh toán (dùng cột tong_gia trong bảng donhang)
$totalRevenue = 0;
$resRevenue = mysqli_query($conn, "SELECT COALESCE(SUM(tong_gia), 0) AS revenue FROM donhang WHERE trang_thai = 'Đã thanh toán'");
if ($resRevenue) {
    $totalRevenue = (float)mysqli_fetch_assoc($resRevenue)['revenue'];
}

// Tổng số sản phẩm
$totalProducts = 0;
$resProducts = mysqli_query($conn, "SELECT COUNT(*) AS total FROM sanpham");
if ($resProducts) {
    $totalProducts = (int)mysqli_fetch_assoc($resProducts)['total'];
}

// Số đơn hàng theo trạng thái
$pending = $shipping = $paid = 0;
$resByStatus = mysqli_query($conn, "
    SELECT trang_thai, COUNT(*) AS total
    FROM donhang
    GROUP BY trang_thai
");
if ($resByStatus) {
    while ($row = mysqli_fetch_assoc($resByStatus)) {
        if ($row['trang_thai'] === 'Chờ giao hàng') {
            $pending = (int)$row['total'];
        } elseif ($row['trang_thai'] === 'Đang giao hàng') {
            $shipping = (int)$row['total'];
        } elseif ($row['trang_thai'] === 'Đã thanh toán') {
            $paid = (int)$row['total'];
        }
    }
}

// Top 5 sản phẩm bán chạy
$topProducts = [];
$resTop = mysqli_query($conn, "SELECT ten_sp, so_luong_da_ban FROM sanpham ORDER BY so_luong_da_ban DESC LIMIT 5");
if ($resTop) {
    while ($row = mysqli_fetch_assoc($resTop)) {
        $topProducts[] = $row;
    }
}
?>

<h2 style="font-size:26px;font-weight:700;margin-bottom:20px;">Tổng quan hệ thống</h2>

<div style="display:flex;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
    <div style="flex:1;min-width:220px;background:linear-gradient(135deg,#eef2ff,#e0f2fe);border-radius:12px;padding:16px;box-shadow:0 10px 25px rgba(15,23,42,0.08);">
        <p style="font-size:13px;color:#4b5563;margin-bottom:4px;">Tổng số đơn hàng</p>
        <p style="font-size:28px;font-weight:700;color:#111827;"><?php echo $totalOrders; ?></p>
    </div>
    <div style="flex:1;min-width:220px;background:linear-gradient(135deg,#ecfdf3,#dcfce7);border-radius:12px;padding:16px;box-shadow:0 10px 25px rgba(15,23,42,0.08);">
        <p style="font-size:13px;color:#4b5563;margin-bottom:4px;">Tổng doanh thu đã thanh toán</p>
        <p style="font-size:28px;font-weight:700;color:#166534;">
            <?php echo number_format($totalRevenue, 0, ',', '.'); ?>₫
        </p>
    </div>
    <div style="flex:1;min-width:220px;background:linear-gradient(135deg,#fef9c3,#fee2e2);border-radius:12px;padding:16px;box-shadow:0 10px 25px rgba(15,23,42,0.08);">
        <p style="font-size:13px;color:#4b5563;margin-bottom:4px;">Tổng số sản phẩm</p>
        <p style="font-size:28px;font-weight:700;color:#7c2d12;"><?php echo $totalProducts; ?></p>
    </div>
</div>

<div style="display:flex;flex-wrap:wrap;gap:24px;">
    <div style="flex:1;min-width:260px;">
        <h3 style="font-size:18px;font-weight:600;margin-bottom:10px;">Đơn hàng theo trạng thái</h3>
        <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 8px 20px rgba(15,23,42,0.06);">
            <thead>
                <tr style="background:#eff6ff;">
                    <th style="padding:8px 12px;text-align:left;font-size:13px;">Trạng thái</th>
                    <th style="padding:8px 12px;text-align:right;font-size:13px;">Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:8px 12px;font-size:13px;">Chờ giao hàng</td>
                    <td style="padding:8px 12px;font-size:13px;text-align:right;"><?php echo $pending; ?></td>
                </tr>
                <tr style="background:#f9fafb;">
                    <td style="padding:8px 12px;font-size:13px;">Đang giao hàng</td>
                    <td style="padding:8px 12px;font-size:13px;text-align:right;"><?php echo $shipping; ?></td>
                </tr>
                <tr>
                    <td style="padding:8px 12px;font-size:13px;">Đã thanh toán</td>
                    <td style="padding:8px 12px;font-size:13px;text-align:right;"><?php echo $paid; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="flex:1;min-width:260px;">
        <h3 style="font-size:18px;font-weight:600;margin-bottom:10px;">Top 5 sản phẩm bán chạy</h3>
        <?php if (!empty($topProducts)): ?>
            <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 8px 20px rgba(15,23,42,0.06);">
                <thead>
                    <tr style="background:#eff6ff;">
                        <th style="padding:8px 12px;text-align:left;font-size:13px;">#</th>
                        <th style="padding:8px 12px;text-align:left;font-size:13px;">Sản phẩm</th>
                        <th style="padding:8px 12px;text-align:right;font-size:13px;">Đã bán</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($topProducts as $i => $p): ?>
                    <tr style="background:<?php echo $i % 2 === 0 ? '#ffffff' : '#f9fafb'; ?>;">
                        <td style="padding:8px 12px;font-size:13px;"><?php echo $i + 1; ?></td>
                        <td style="padding:8px 12px;font-size:13px;"><?php echo htmlspecialchars($p['ten_sp']); ?></td>
                        <td style="padding:8px 12px;font-size:13px;text-align:right;"><?php echo (int)$p['so_luong_da_ban']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="font-size:14px;color:#6b7280;">Chưa có dữ liệu bán hàng.</p>
        <?php endif; ?>
    </div>
</div>


