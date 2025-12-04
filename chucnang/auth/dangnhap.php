<?php
// Đăng nhập khách hàng (được include trong index.php)

$email = $email ?? '';
$error = $error ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mat_khau = $_POST['mat_khau'] ?? '';

    if ($email === '' || $mat_khau === '') {
        $error = 'Vui lòng nhập đầy đủ email và mật khẩu.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ.';
    } else {
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM khachhang WHERE email = '$email_escaped' LIMIT 1";
        $rs = mysqli_query($conn, $sql);

        if ($rs && mysqli_num_rows($rs) === 1) {
            $row = mysqli_fetch_assoc($rs);
            if (password_verify($mat_khau, $row['mat_khau'])) {
                $_SESSION['khachhang'] = [
                    'id_khachhang'  => $row['id_khachhang'],
                    'ten_khachhang' => $row['ten_khachhang'],
                    'email'         => $row['email'],
                    'so_dien_thoai' => $row['so_dien_thoai'],
                    'dia_chi'       => $row['dia_chi']
                ];
                // Không dùng header() vì đã có output; dùng JavaScript để chuyển trang
                echo '<script>window.location.href = "index.php";</script>';
                exit;
            } else {
                $error = 'Mật khẩu không chính xác.';
            }
        } else {
            $error = 'Tài khoản không tồn tại.';
        }
    }
}
?>

<div class="min-h-[60vh] flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        <div class="text-center">
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Đăng nhập khách hàng</h2>
            <p class="mt-2 text-sm text-gray-600">
                Chưa có tài khoản?
                <a href="index.php?page_layout=dangky" class="font-medium text-blue-600 hover:text-blue-500">
                    Đăng ký ngay
                </a>
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

        <form class="mt-8 space-y-6" method="post">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                           value="<?php echo htmlspecialchars($email); ?>"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                    <input type="password" name="mat_khau" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                                  focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                               text-sm font-medium text-white bg-blue-600 hover:bg-blue-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Đăng nhập
                </button>
            </div>
        </form>
    </div>
</div>


