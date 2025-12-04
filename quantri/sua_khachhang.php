<?php
if (!isset($_SESSION)) {
    session_start();
}
require "../cauhinh/ketnoi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo "ID khách hàng không hợp lệ.";
    return;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten  = trim($_POST['ten_khachhang'] ?? '');
    $sdt  = trim($_POST['so_dien_thoai'] ?? '');
    $diachi = trim($_POST['dia_chi'] ?? '');

    if ($ten === '') {
        $error = 'Tên khách hàng không được để trống.';
    } else {
        $ten_esc = mysqli_real_escape_string($conn, $ten);
        $sdt_esc = mysqli_real_escape_string($conn, $sdt);
        $dc_esc  = mysqli_real_escape_string($conn, $diachi);

        $sql = "UPDATE khachhang 
                SET ten_khachhang = '$ten_esc',
                    so_dien_thoai = '$sdt_esc',
                    dia_chi       = '$dc_esc'
                WHERE id_khachhang = $id";
        mysqli_query($conn, $sql);
        header("Location: quantri.php?page_layout=khachhang");
        exit;
    }
}

$sql = "SELECT * FROM khachhang WHERE id_khachhang = $id LIMIT 1";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

if (!$row) {
    echo "Không tìm thấy khách hàng.";
    return;
}
?>

<h2 style="font-size:24px;font-weight:700;margin-bottom:20px;">Sửa thông tin khách hàng</h2>

<?php if (!empty($error)): ?>
    <div style="margin-bottom:12px;padding:10px;border-radius:8px;background:#fee2e2;color:#b91c1c;font-size:13px;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="post" style="max-width:600px;background:#ffffff;padding:20px;border-radius:12px;box-shadow:0 10px 25px rgba(15,23,42,0.08);">
    <div style="margin-bottom:12px;">
        <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">Tên khách hàng</label>
        <input type="text" name="ten_khachhang"
               value="<?php echo htmlspecialchars($row['ten_khachhang']); ?>"
               style="width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;">
    </div>

    <div style="margin-bottom:12px;">
        <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">Email</label>
        <input type="email" disabled
               value="<?php echo htmlspecialchars($row['email']); ?>"
               style="width:100%;padding:8px 10px;border:1px solid #e5e7eb;border-radius:6px;font-size:14px;background:#f9fafb;color:#6b7280;">
    </div>

    <div style="margin-bottom:12px;">
        <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">Số điện thoại</label>
        <input type="text" name="so_dien_thoai"
               value="<?php echo htmlspecialchars($row['so_dien_thoai']); ?>"
               style="width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;">
    </div>

    <div style="margin-bottom:16px;">
        <label style="display:block;font-size:14px;font-weight:600;margin-bottom:4px;">Địa chỉ</label>
        <textarea name="dia_chi" rows="3"
                  style="width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:6px;font-size:14px;"><?php echo htmlspecialchars($row['dia_chi']); ?></textarea>
    </div>

    <button type="submit"
            style="padding:8px 18px;background:#2563eb;color:#ffffff;border:none;border-radius:6px;font-size:14px;font-weight:600;cursor:pointer;">
        Lưu thay đổi
    </button>
</form>


