<?php

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

        // Đăng nhập khách hàng (bảng khachhang)
        $sql_khachhang = "SELECT * FROM khachhang WHERE email = '$email_escaped' LIMIT 1";
        $rs_khachhang = mysqli_query($conn, $sql_khachhang);

        if ($rs_khachhang && mysqli_num_rows($rs_khachhang) === 1) {
            $row_khachhang = mysqli_fetch_assoc($rs_khachhang);

            $hash = $row_khachhang['mat_khau'];
            // Hỗ trợ cả mật khẩu dạng hash mới và mật khẩu text cũ trong database
            $isValidPassword = password_verify($mat_khau, $hash) || ($mat_khau === $hash);

            if ($isValidPassword) {
                $_SESSION['khachhang'] = [
                    'id_khachhang'  => $row_khachhang['id_khachhang'],
                    'ten_khachhang' => $row_khachhang['ten_khachhang'],
                    'email'         => $row_khachhang['email'],
                    'so_dien_thoai' => $row_khachhang['so_dien_thoai'],
                    'dia_chi'       => $row_khachhang['dia_chi']
                ];
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
                <br />
                <a href="index.php?page_layout=quenmatkhau" class="text-xs text-gray-500 hover:text-blue-500">
                    Quên mật khẩu?
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

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Hoặc đăng nhập bằng</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-3">
                <div>
                    <button id="google-signin-button"
                            class="w-full flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm
                                   bg-white text-sm font-medium text-gray-700 hover:bg-gray-50
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <img src="https://www.citypng.com/public/uploads/preview/google-logo-icon-gsuite-hd-701751694791470gzbayltphh.png" class="h-5 w-5 mr-2" alt="Google Logo">
                        Đăng nhập với Google
                    </button>
                </div>
                <div>
                    <button id="facebook-signin-button"
                            class="w-full flex justify-center items-center py-2 px-4 border border-gray-300 rounded-md shadow-sm
                                   bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" class="h-5 w-5 mr-2" alt="Facebook Logo">
                        Đăng nhập với Facebook
                    </button>
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
    const loginConfig = <?php echo json_encode($firebase_client_config); ?>;

    if (!firebase.apps.length) {
        firebase.initializeApp(loginConfig);
    } else {
        firebase.app(); 
    }

    const firebaseAuth = firebase.auth();
    const googleProvider = new firebase.auth.GoogleAuthProvider();
    const facebookProvider = new firebase.auth.FacebookAuthProvider();

    // Xử lý Google
    const btnGoogle = document.getElementById('google-signin-button');
    if(btnGoogle) {
        btnGoogle.addEventListener('click', (e) => {
            e.preventDefault();
            firebaseAuth.signInWithPopup(googleProvider)
                .then((result) => result.user.getIdToken())
                .then((idToken) => sendTokenToBackend(idToken))
                .catch((error) => alert("Lỗi Google: " + error.message));
        });
    }

    // Xử lý Facebook (tạm thời chưa hỗ trợ)
    const btnFacebook = document.getElementById('facebook-signin-button');
    if (btnFacebook) {
        btnFacebook.addEventListener('click', (e) => {
            e.preventDefault();
        });
    }

    function sendTokenToBackend(idToken) {
        // ĐƯỜNG DẪN QUAN TRỌNG: Gọi từ index.php vào thư mục con
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
        .catch((error) => {
            console.error('Error:', error);
            alert('Lỗi kết nối máy chủ.');
        });
    }
</script>