<?php

$email = $email ?? '';
$so_dien_thoai = $so_dien_thoai ?? '';
$error = $error ?? '';
$success = $success ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email         = trim($_POST['email'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
    $mat_khau      = $_POST['mat_khau'] ?? '';
    $mat_khau_confirm = $_POST['mat_khau_confirm'] ?? '';

    if ($email === '' || $so_dien_thoai === '' || $mat_khau === '' || $mat_khau_confirm === '') {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ.';
    } elseif ($mat_khau !== $mat_khau_confirm) {
        $error = 'Mật khẩu nhập lại không khớp.';
    } elseif (strlen($mat_khau) < 6) {
        $error = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
    } else {
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $sdt_escaped   = mysqli_real_escape_string($conn, $so_dien_thoai);

        // Tìm khách hàng với email + số điện thoại khớp
        $sql_check = "
            SELECT id_khachhang 
            FROM khachhang 
            WHERE email = '$email_escaped' AND so_dien_thoai = '$sdt_escaped'
            LIMIT 1
        ";
        $rs_check = mysqli_query($conn, $sql_check);

        if ($rs_check && mysqli_num_rows($rs_check) === 1) {
            $row = mysqli_fetch_assoc($rs_check);
            $id_khachhang = (int)$row['id_khachhang'];

            $hash = password_hash($mat_khau, PASSWORD_BCRYPT);
            $hash_escaped = mysqli_real_escape_string($conn, $hash);

            $sql_update = "
                UPDATE khachhang 
                SET mat_khau = '$hash_escaped'
                WHERE id_khachhang = $id_khachhang
                LIMIT 1
            ";

            if (mysqli_query($conn, $sql_update)) {
                $success = 'Đổi mật khẩu thành công. Hệ thống sẽ chuyển bạn về trang đăng nhập...';
                // Xoá giá trị form
                $email = '';
                $so_dien_thoai = '';
            } else {
                $error = 'Có lỗi khi cập nhật mật khẩu. Vui lòng thử lại.';
            }
        } else {
            $error = 'Không tìm thấy tài khoản phù hợp với email và số điện thoại đã nhập.';
        }
    }
}
?>

<div class="min-h-[60vh] flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-6 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Quên mật khẩu</h2>
            <p class="mt-2 text-sm text-gray-600">
                Nhập email, số điện thoại đã đăng ký và mật khẩu mới để đặt lại.
            </p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800"><?php echo htmlspecialchars($error); ?></h3>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800"><?php echo htmlspecialchars($success); ?></h3>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form class="mt-4 space-y-5" method="post">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email đã đăng ký</label>
                    <input type="email" name="email" required
                           value="<?php echo htmlspecialchars($email); ?>"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại đã đăng ký</label>
                    <input type="text" name="so_dien_thoai" required
                           value="<?php echo htmlspecialchars($so_dien_thoai); ?>"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                    <input type="password" name="mat_khau" required
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu mới</label>
                    <input type="password" name="mat_khau_confirm" required
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                               text-sm font-medium text-white bg-blue-600 hover:bg-blue-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Đặt lại mật khẩu
                </button>
            </div>

            <div class="text-center mt-3">
                <a href="index.php?page_layout=dangnhap" class="text-sm text-blue-600 hover:text-blue-500">
                    Quay lại đăng nhập
                </a>
            </div>
        </form>
    </div>
</div>

<?php if (!empty($success)): ?>
    <script>
        // Sau khi đổi mật khẩu thành công, tự động chuyển sang trang đăng nhập sau 2 giây
        setTimeout(function () {
            window.location.href = 'index.php?page_layout=dangnhap';
        }, 2000);
    </script>
<?php endif; ?>


