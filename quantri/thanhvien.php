

<?php
// Chỉ cho phép chủ shop truy cập
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['vai_tro']) || $_SESSION['vai_tro'] !== 'chu_shop') {
    die('Bạn không có quyền truy cập trang quản lý thành viên.');
}

require "../cauhinh/ketnoi.php";

// Lấy danh sách thành viên
$sql   = "SELECT * FROM thanhvien ORDER BY id_thanhvien ASC";
$query = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" type="text/css" href="css/thanhvien.css" />

<div class="tv-wrapper">
    <div class="tv-header-row">
        <div>
            <h1 class="tv-title">Quản lý thành viên</h1>
            <p class="tv-subtitle">Quản lý tài khoản đăng nhập hệ thống quản trị (chủ shop và nhân viên).</p>
        </div>
        <div class="tv-header-actions">
            <form method="get" action="quantri.php" class="tv-search-form">
                <input type="hidden" name="page_layout" value="thanhvien" />
                <input
                    type="text"
                    name="keyword"
                    class="tv-search-input"
                    placeholder="Tìm theo email..."
                    value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                />
                <button type="submit" class="tv-search-btn">Tìm kiếm</button>
            </form>
            <a href="quantri.php?page_layout=them_thanhvien" class="btn-add-thanhvien">+ Thêm thành viên</a>
        </div>
    </div>

    <div class="tv-table-wrapper">
        <table class="tv-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Mật khẩu</th>
                    <th class="tv-col-actions">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($query && mysqli_num_rows($query) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($query)): ?>
                        <?php
                        $role      = $row['vai_tro'] ?? 'nhan_vien';
                        $roleLabel = $role === 'chu_shop' ? 'Chủ shop' : 'Nhân viên';
                        $isOwner   = ($role === 'chu_shop');
                        ?>
                        <tr>
                            <td><?php echo (int)$row['id_thanhvien']; ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <span class="tv-role-badge <?php echo $isOwner ? 'tv-role-owner' : 'tv-role-staff'; ?>">
                                    <?php echo $roleLabel; ?>
                                </span>
                            </td>
                            <td class="tv-password-cell">
                                <span class="tv-password-mask">••••••••</span>
                                <span class="tv-password-note">(ẩn vì lý do bảo mật)</span>
                            </td>
                            <td class="tv-actions">
                                <a
                                    href="quantri.php?page_layout=sua_thanhvien&id=<?php echo (int)$row['id_thanhvien']; ?>"
                                    class="btn-edit-thanhvien"
                                >
                                    Sửa
                                </a>
                                <?php if (!$isOwner): ?>
                                    <a
                                        href="xoa_thanhvien.php?id=<?php echo (int)$row['id_thanhvien']; ?>"
                                        class="btn-delete-thanhvien"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa thành viên này?');"
                                    >
                                        Xóa
                                    </a>
                                <?php else: ?>
                                    <span class="tv-protect-label">Không thể xoá</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center; padding:16px; font-size:14px; color:#6b7280;">
                            Chưa có thành viên nào.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
