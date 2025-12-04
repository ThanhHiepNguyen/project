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

$id_bl = isset($_GET['id_bl']) ? (int)$_GET['id_bl'] : 0;
if ($id_bl <= 0) {
    header("Location: quantri.php?page_layout=binhluan");
    exit;
}

// Lấy thông tin bình luận
$sql = "
    SELECT b.*, s.ten_sp
    FROM blsanpham AS b
    LEFT JOIN sanpham AS s ON b.id_sp = s.id_sp
    WHERE b.id_bl = $id_bl
    LIMIT 1
";
$res = mysqli_query($conn, $sql);
if (!$res || mysqli_num_rows($res) === 0) {
    header("Location: quantri.php?page_layout=binhluan");
    exit;
}

$comment = mysqli_fetch_assoc($res);
$phan_hoi_admin = $comment['phan_hoi_admin'] ?? '';

// Xử lý lưu phản hồi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phan_hoi_admin = trim($_POST['phan_hoi_admin'] ?? '');
    $phan_hoi_escaped = mysqli_real_escape_string($conn, $phan_hoi_admin);

    $sql_update = "
        UPDATE blsanpham
        SET phan_hoi_admin = '$phan_hoi_escaped'
        WHERE id_bl = $id_bl
        LIMIT 1
    ";
    mysqli_query($conn, $sql_update);

    header("Location: quantri.php?page_layout=binhluan");
    exit;
}
?>

<div class="tv-wrapper">
    <div class="tv-header-row">
        <div>
            <h1 class="tv-title">Trả lời bình luận</h1>
            <p class="tv-subtitle">
                Sản phẩm: <strong><?php echo htmlspecialchars($comment['ten_sp'] ?? 'Sản phẩm đã xoá'); ?></strong>
            </p>
        </div>
    </div>

    <div class="tv-table-wrapper" style="padding:16px 18px;">
        <div style="margin-bottom:16px; font-size:13px;">
            <div style="margin-bottom:6px;">
                <strong>Khách hàng:</strong>
                <?php echo htmlspecialchars($comment['ten']); ?>
                <?php if (!empty($comment['dien_thoai'])): ?>
                    <span style="color:#6b7280;">(<?php echo htmlspecialchars($comment['dien_thoai']); ?>)</span>
                <?php endif; ?>
            </div>
            <div style="margin-bottom:6px;">
                <strong>Thời gian:</strong>
                <?php echo date('d/m/Y H:i', strtotime($comment['ngay_gio'])); ?>
            </div>
            <div>
                <strong>Nội dung bình luận:</strong>
                <div style="margin-top:4px; white-space:pre-line; background:#f9fafb; border-radius:6px; padding:8px 10px; border:1px solid #e5e7eb;">
                    <?php echo nl2br(htmlspecialchars($comment['binh_luan'])); ?>
                </div>
            </div>
        </div>

        <form method="post">
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:6px;">
                    Phản hồi của quản trị viên
                </label>
                <textarea
                    name="phan_hoi_admin"
                    rows="4"
                    style="width:100%; padding:8px 10px; border-radius:8px; border:1px solid #d1d5db; font-size:13px; resize:vertical;"
                ><?php echo htmlspecialchars($phan_hoi_admin); ?></textarea>
            </div>

            <div style="display:flex; gap:8px; margin-top:12px;">
                <button
                    type="submit"
                    class="btn-edit-thanhvien"
                    style="border:none; cursor:pointer;"
                >
                    Lưu phản hồi
                </button>
                <a
                    href="quantri.php?page_layout=binhluan"
                    class="btn-delete-thanhvien"
                    style="background-color:#6b7280;"
                >
                    Quay lại
                </a>
            </div>
        </form>
    </div>
</div>


