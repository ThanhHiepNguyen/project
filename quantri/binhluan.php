<?php
if (!isset($_SESSION)) {
    session_start();
}

require "../cauhinh/ketnoi.php";

// Chỉ cho phép người đã đăng nhập vào khu vực quản trị
if (!isset($_SESSION['tk'])) {
    header("Location: index.php");
    exit;
}

// Lấy danh sách bình luận + thông tin sản phẩm
$sql = "
    SELECT b.*, s.ten_sp
    FROM blsanpham AS b
    LEFT JOIN sanpham AS s ON b.id_sp = s.id_sp
    ORDER BY b.ngay_gio DESC, b.id_bl DESC
";
$result = mysqli_query($conn, $sql);
?>

<div class="tv-wrapper">
    <div class="tv-header-row">
        <div>
            <h1 class="tv-title">Quản lý bình luận sản phẩm</h1>
            <p class="tv-subtitle">
                Xem và trả lời bình luận của khách hàng cho từng sản phẩm.
            </p>
        </div>
    </div>

    <div class="tv-table-wrapper">
        <table class="tv-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Khách hàng</th>
                    <th>Nội dung</th>
                    <th>Phản hồi admin</th>
                    <th>Thời gian</th>
                    <th class="tv-col-actions">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo (int)$row['id_bl']; ?></td>
                            <td>
                                <?php echo htmlspecialchars($row['ten_sp'] ?? 'Sản phẩm đã xoá'); ?>
                            </td>
                            <td>
                                <div style="font-weight:600;"><?php echo htmlspecialchars($row['ten']); ?></div>
                                <?php if (!empty($row['dien_thoai'])): ?>
                                    <div style="font-size:11px; color:#6b7280;">
                                        <?php echo htmlspecialchars($row['dien_thoai']); ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td style="max-width:260px; white-space:pre-line; font-size:13px;">
                                <?php echo nl2br(htmlspecialchars($row['binh_luan'])); ?>
                            </td>
                            <td style="max-width:260px; white-space:pre-line; font-size:13px; color:#1f2937;">
                                <?php
                                if (!empty($row['phan_hoi_admin'])) {
                                    echo nl2br(htmlspecialchars($row['phan_hoi_admin']));
                                } else {
                                    echo '<span style="color:#9ca3af; font-style:italic;">Chưa có phản hồi</span>';
                                }
                                ?>
                            </td>
                            <td style="font-size:12px; color:#6b7280;">
                                <?php echo date('d/m/Y H:i', strtotime($row['ngay_gio'])); ?>
                            </td>
                            <td class="tv-actions">
                                <a
                                    href="quantri.php?page_layout=sua_binhluan&id_bl=<?php echo (int)$row['id_bl']; ?>"
                                    class="btn-edit-thanhvien"
                                >
                                    Trả lời
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding:16px; font-size:14px; color:#6b7280;">
                            Chưa có bình luận nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


