<?php
// Trang Hồ sơ khách hàng
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['khachhang'])) {
    echo '<div class="min-h-[50vh] flex items-center justify-center">
            <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-md w-full">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Bạn chưa đăng nhập</h2>
                <p class="text-gray-600 mb-6">Vui lòng đăng nhập để quản lý hồ sơ cá nhân.</p>
                <a href="index.php?page_layout=dangnhap"
                   class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    Đăng nhập
                </a>
            </div>
          </div>';
    return;
}

$id_khachhang = (int)$_SESSION['khachhang']['id_khachhang'];
$error = '';
$success = '';

// Lấy thông tin hiện tại
$sql_info = "SELECT * FROM khachhang WHERE id_khachhang = $id_khachhang LIMIT 1";
$res_info = mysqli_query($conn, $sql_info);
$user = mysqli_fetch_assoc($res_info);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khachhang = trim($_POST['ten_khachhang'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $dia_chi       = trim($_POST['dia_chi'] ?? '');

    $old_password  = $_POST['old_password'] ?? '';
    $new_password  = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($ten_khachhang === '') {
        $error = 'Tên khách hàng không được để trống.';
    } else {
        // Cập nhật thông tin cơ bản
        $ten_esc = mysqli_real_escape_string($conn, $ten_khachhang);
        $sdt_esc = mysqli_real_escape_string($conn, $so_dien_thoai);
        $dc_esc  = mysqli_real_escape_string($conn, $dia_chi);

        $update_sql = "UPDATE khachhang 
                       SET ten_khachhang = '$ten_esc',
                           so_dien_thoai = '$sdt_esc',
                           dia_chi       = '$dc_esc'
                       WHERE id_khachhang = $id_khachhang";
        mysqli_query($conn, $update_sql);

        // Cập nhật session
        $_SESSION['khachhang']['ten_khachhang'] = $ten_khachhang;
        $_SESSION['khachhang']['so_dien_thoai'] = $so_dien_thoai;
        $_SESSION['khachhang']['dia_chi']       = $dia_chi;

        // Xử lý đổi mật khẩu nếu có nhập
        if ($old_password !== '' || $new_password !== '' || $confirm_password !== '') {
            if ($old_password === '' || $new_password === '' || $confirm_password === '') {
                $error = 'Vui lòng nhập đầy đủ mật khẩu cũ, mật khẩu mới và xác nhận mật khẩu.';
            } elseif ($new_password !== $confirm_password) {
                $error = 'Mật khẩu mới và xác nhận mật khẩu không khớp.';
            } elseif (strlen($new_password) < 6) {
                $error = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
            } else {
                $sql_pw = "SELECT mat_khau FROM khachhang WHERE id_khachhang = $id_khachhang LIMIT 1";
                $res_pw = mysqli_query($conn, $sql_pw);
                $row_pw = mysqli_fetch_assoc($res_pw);

                if (!$row_pw || !password_verify($old_password, $row_pw['mat_khau'])) {
                    $error = 'Mật khẩu cũ không chính xác.';
                } else {
                    $new_hash = password_hash($new_password, PASSWORD_BCRYPT);
                    mysqli_query($conn, "UPDATE khachhang SET mat_khau = '$new_hash' WHERE id_khachhang = $id_khachhang");
                    $success = 'Cập nhật hồ sơ và mật khẩu thành công.';
                }
            }
        } else {
            if ($error === '') {
                $success = 'Cập nhật hồ sơ thành công.';
            }
        }

        // Reload lại dữ liệu mới
        $res_info = mysqli_query($conn, $sql_info);
        $user = mysqli_fetch_assoc($res_info);
    }
}
?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Hồ sơ cá nhân</h2>

        <?php if (!empty($error)): ?>
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif (!empty($success)): ?>
            <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="post" class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Họ tên</label>
                    <input type="text" name="ten_khachhang"
                           value="<?php echo htmlspecialchars($user['ten_khachhang']); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email (không đổi)</label>
                    <input type="email" disabled
                           value="<?php echo htmlspecialchars($user['email']); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-200 rounded-md bg-gray-50 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                    <input type="text" name="so_dien_thoai"
                           value="<?php echo htmlspecialchars($user['so_dien_thoai']); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                    <textarea name="dia_chi" rows="3"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                     focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo htmlspecialchars($user['dia_chi']); ?></textarea>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Đổi mật khẩu</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Nếu không muốn đổi mật khẩu, hãy để trống cả ba ô bên dưới.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mật khẩu hiện tại</label>
                        <input type="password" name="old_password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                      focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                        <input type="password" name="new_password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                      focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                      focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>


