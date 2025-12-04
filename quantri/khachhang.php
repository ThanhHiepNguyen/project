<?php
if (!isset($_SESSION)) {
    session_start();
}
require "../cauhinh/ketnoi.php";

$sql = "SELECT * FROM khachhang ORDER BY id_khachhang DESC";
$query = mysqli_query($conn, $sql);
?>

<h2 style="font-size:24px;font-weight:700;margin-bottom:20px;">Quản lý khách hàng</h2>

<?php if (isset($_SESSION['error_khachhang'])): ?>
    <script>
        alert("<?php echo addslashes($_SESSION['error_khachhang']); ?>");
    </script>
    <?php unset($_SESSION['error_khachhang']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success_khachhang'])): ?>
    <script>
        alert("<?php echo addslashes($_SESSION['success_khachhang']); ?>");
    </script>
    <?php unset($_SESSION['success_khachhang']); ?>
<?php endif; ?>

<div style="overflow-x:auto;">
    <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 10px 25px rgba(15,23,42,0.08);">
        <thead>
            <tr style="background:linear-gradient(90deg,#eff6ff,#e0f2fe);">
                <th style="padding:10px 12px;text-align:left;font-size:13px;">ID</th>
                <th style="padding:10px 12px;text-align:left;font-size:13px;">Tên khách hàng</th>
                <th style="padding:10px 12px;text-align:left;font-size:13px;">Email</th>
                <th style="padding:10px 12px;text-align:left;font-size:13px;">Số điện thoại</th>
                <th style="padding:10px 12px;text-align:left;font-size:13px;">Địa chỉ</th>
                <th style="padding:10px 12px;text-align:left;font-size:13px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <tr style="border-bottom:1px solid #e5e7eb;background:#ffffff;">
                <td style="padding:8px 12px;font-size:13px;"><?php echo $row['id_khachhang']; ?></td>
                <td style="padding:8px 12px;font-size:13px;"><?php echo htmlspecialchars($row['ten_khachhang']); ?></td>
                <td style="padding:8px 12px;font-size:13px;"><?php echo htmlspecialchars($row['email']); ?></td>
                <td style="padding:8px 12px;font-size:13px;"><?php echo htmlspecialchars($row['so_dien_thoai']); ?></td>
                <td style="padding:8px 12px;font-size:13px;"><?php echo htmlspecialchars($row['dia_chi']); ?></td>
                <td style="padding:8px 12px;font-size:13px;">
                    <a href="quantri.php?page_layout=sua_khachhang&id=<?php echo $row['id_khachhang']; ?>"
                       style="margin-right:8px;color:#2563eb;text-decoration:none;font-weight:500;">Sửa</a>
                    <a href="xoa_khachhang.php?id=<?php echo $row['id_khachhang']; ?>"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');"
                       style="color:#dc2626;text-decoration:none;font-weight:500;">Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>


