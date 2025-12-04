<?php


$errors = $errors ?? [
    'ten_khachhang' => '',
    'email' => '',
    'mat_khau' => '',
    'mat_khau_confirm' => ''
];

$ten_khachhang = $ten_khachhang ?? '';
$email = $email ?? '';
$mat_khau = $mat_khau ?? '';
$mat_khau_confirm = $mat_khau_confirm ?? '';
$so_dien_thoai = $so_dien_thoai ?? '';
$dia_chi = $dia_chi ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_khachhang    = trim($_POST['ten_khachhang'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $mat_khau         = $_POST['mat_khau'] ?? '';
    $mat_khau_confirm = $_POST['mat_khau_confirm'] ?? '';
    $so_dien_thoai    = trim($_POST['so_dien_thoai'] ?? '');
    $dia_chi          = trim($_POST['dia_chi'] ?? '');

    $has_error = false;

    if ($ten_khachhang === '') {
        $errors['ten_khachhang'] = 'Vui lòng nhập họ tên.';
        $has_error = true;
    } else {
        $errors['ten_khachhang'] = '';
    }

    if ($email === '') {
        $errors['email'] = 'Vui lòng nhập email.';
        $has_error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ.';
        $has_error = true;
    } else {
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $sql_check = "SELECT id_khachhang FROM khachhang WHERE email = '$email_escaped' LIMIT 1";
        $rs_check = mysqli_query($conn, $sql_check);
        if ($rs_check && mysqli_num_rows($rs_check) > 0) {
            $errors['email'] = 'Email đã được sử dụng. Vui lòng dùng email khác.';
            $has_error = true;
        } else {
            $errors['email'] = '';
        }
    }

    if ($mat_khau === '') {
        $errors['mat_khau'] = 'Vui lòng nhập mật khẩu.';
        $has_error = true;
    } elseif (strlen($mat_khau) < 6) {
        $errors['mat_khau'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        $has_error = true;
    } else {
        $errors['mat_khau'] = '';
    }

    if ($mat_khau_confirm === '') {
        $errors['mat_khau_confirm'] = 'Vui lòng nhập lại mật khẩu.';
        $has_error = true;
    } elseif ($mat_khau_confirm !== $mat_khau) {
        $errors['mat_khau_confirm'] = 'Mật khẩu nhập lại không khớp.';
        $has_error = true;
    } else {
        $errors['mat_khau_confirm'] = '';
    }

    if (!$has_error) {
        $ten_escaped   = mysqli_real_escape_string($conn, $ten_khachhang);
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $sdt_escaped   = mysqli_real_escape_string($conn, $so_dien_thoai);
        $diachi_escaped= mysqli_real_escape_string($conn, $dia_chi);
        $hash          = password_hash($mat_khau, PASSWORD_BCRYPT);

        $sql_insert = "
            INSERT INTO khachhang (ten_khachhang, email, mat_khau, so_dien_thoai, dia_chi)
            VALUES ('$ten_escaped', '$email_escaped', '$hash', '$sdt_escaped', '$diachi_escaped')
        ";

        if (mysqli_query($conn, $sql_insert)) {
            // Sau khi đăng ký thành công, chuyển sang trang đăng nhập thay vì auto đăng nhập
            echo '<script>alert("Đăng ký thành công. Vui lòng đăng nhập để tiếp tục."); window.location.href = "index.php?page_layout=dangnhap";</script>';
            exit;
        } else {
            $errors['email'] = 'Có lỗi khi tạo tài khoản. Vui lòng thử lại.';
        }
    }
}
?>

<div class="min-h-[80vh] flex items-center justify-center py-10 px-4 bg-gradient-to-br from-blue-50 via-white to-blue-100">
    <div class="max-w-4xl w-full grid gap-8 md:grid-cols-2 items-stretch">
        <!-- Intro panel (minimal) -->
        <div class="hidden md:flex flex-col justify-center rounded-2xl bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 text-white p-8 shadow-2xl">
            <div>
                <h2 class="text-3xl font-extrabold mb-3">Chào mừng đến với Hạnh Phương</h2>
                <p class="text-sm md:text-base text-blue-100">
                    Đăng ký tài khoản để mua hàng nhanh hơn và theo dõi đơn của bạn.
                </p>
            </div>
        </div>

        <!-- Form panel -->
        <div class="w-full space-y-6 bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-gray-100 p-6 sm:p-8">
            <div class="text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Đăng ký tài khoản</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Đã có tài khoản?
                    <a href="index.php?page_layout=dangnhap" class="font-semibold text-blue-600 hover:text-blue-500">
                        Đăng nhập ngay
                    </a>
                </p>
            </div>

            <form class="mt-4 space-y-5" method="post">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                        <input type="text" name="ten_khachhang" required
                               value="<?php echo htmlspecialchars($ten_khachhang); ?>"
                               class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <?php if (!empty($errors['ten_khachhang'])): ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo $errors['ten_khachhang']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required
                               value="<?php echo htmlspecialchars($email); ?>"
                               class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <?php if (!empty($errors['email'])): ?>
                            <p class="mt-1 text-xs text-red-600"><?php echo $errors['email']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                            <input type="password" name="mat_khau" required
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <?php if (!empty($errors['mat_khau'])): ?>
                                <p class="mt-1 text-xs text-red-600"><?php echo $errors['mat_khau']; ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu</label>
                            <input type="password" name="mat_khau_confirm" required
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <?php if (!empty($errors['mat_khau_confirm'])): ?>
                                <p class="mt-1 text-xs text-red-600"><?php echo $errors['mat_khau_confirm']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                            <input type="text" name="so_dien_thoai"
                                   value="<?php echo htmlspecialchars($so_dien_thoai); ?>"
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                            <input type="text" name="dia_chi"
                                   value="<?php echo htmlspecialchars($dia_chi); ?>"
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-md
                                   text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-150">
                        <i class="fa-solid fa-user-plus mr-2"></i>
                        Đăng ký tài khoản
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Hoặc đăng ký bằng</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-3">
                    <div>
                        <button id="google-signup-button"
                                class="w-full flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm
                                       bg-white text-sm font-medium text-gray-700 hover:bg-gray-50
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <img src="https://www.citypng.com/public/uploads/preview/google-logo-icon-gsuite-hd-701751694791470gzbayltphh.png" class="h-5 w-5 mr-2" alt="Google Logo">
                            Đăng ký với Google
                        </button>
                    </div>
                    <div>
                        <button id="facebook-signup-button"
                                class="w-full flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm
                                       bg-white text-sm font-medium text-gray-700 hover:bg-gray-50
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" class="h-5 w-5 mr-2" alt="Facebook Logo">
                            Đăng ký với Facebook
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../cauhinh/firebase_config.php'; ?>

<script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-auth-compat.js"></script>

<script>
    // ĐỔI TÊN BIẾN
    const registerConfig = <?php echo json_encode($firebase_client_config); ?>;

    if (!firebase.apps.length) {
        firebase.initializeApp(registerConfig);
    } else {
        firebase.app(); 
    }

    const firebaseAuth = firebase.auth();
    const googleProvider = new firebase.auth.GoogleAuthProvider();
    const facebookProvider = new firebase.auth.FacebookAuthProvider();

    // Nút Google
    const btnGoogleReg = document.getElementById('google-signup-button');
    if(btnGoogleReg) {
        btnGoogleReg.addEventListener('click', (e) => {
            e.preventDefault();
            firebaseAuth.signInWithPopup(googleProvider)
                .then((result) => result.user.getIdToken())
                .then((idToken) => sendTokenToBackend(idToken)) // Dùng chung hàm xử lý backend
                .catch((error) => alert("Lỗi Google: " + error.message));
        });
    }

    // Nút Facebook
    const btnFacebookReg = document.getElementById('facebook-signup-button');
    if(btnFacebookReg) {
        btnFacebookReg.addEventListener('click', (e) => {
            e.preventDefault();
            firebaseAuth.signInWithPopup(facebookProvider)
                .then((result) => result.user.getIdToken())
                .then((idToken) => sendTokenToBackend(idToken))
                .catch((error) => alert("Lỗi Facebook: " + error.message));
        });
    }

    function sendTokenToBackend(idToken) {
        fetch('chucnang/auth/handle_firebase_auth.php', { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ idToken: idToken }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.php'; 
            } else {
                alert(data.message);
            }
        })
        .catch((error) => console.error('Error:', error));
    }
</script>