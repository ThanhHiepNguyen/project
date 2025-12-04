<?php
// chucnang/auth/handle_firebase_auth.php
session_start();
header('Content-Type: application/json');

// 1. Load các file cần thiết (Đường dẫn tính từ chucnang/auth/)
require_once __DIR__ . '/../../vendor/autoload.php'; 
require_once __DIR__ . '/../../cauhinh/firebase_config.php';
// require_once __DIR__ . '/../../cauhinh/ketnoi.php'; 
// Lưu ý: Nếu file ketnoi.php không tự chạy, hãy mở comment dòng trên. 
// Tuy nhiên, đoạn dưới tôi sẽ viết code kết nối đảm bảo chạy được ngay tại đây.

use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\Auth\InvalidToken;

$response = ['success' => false, 'message' => 'Lỗi không xác định.'];

// 2. Kết nối Database (Copy từ ketnoi.php để đảm bảo scope)
if (!isset($conn)) {
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'phukienshop';
    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, '3306');
    if ($conn) {
        mysqli_set_charset($conn, 'utf8');
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi kết nối CSDL: ' . mysqli_connect_error()]);
        exit;
    }
}

// 3. Kiểm tra file Service Account
if (!file_exists($firebase_service_account_path)) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy file cấu hình Service Account JSON.']);
    exit;
}

try {
    // 4. Khởi tạo Firebase Auth
    $factory = (new Factory)->withServiceAccount($firebase_service_account_path);
    $auth = $factory->createAuth();
} catch (\Throwable $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi khởi tạo SDK: ' . $e->getMessage()]);
    exit;
}

// 5. Nhận Token
$input = file_get_contents('php://input');
$data = json_decode($input, true);
$idToken = $data['idToken'] ?? null;

if (empty($idToken)) {
    echo json_encode(['success' => false, 'message' => 'Không nhận được Token.']);
    exit;
}

try {
    // 6. Xác thực Token
    // Cho phép sai lệch đồng hồ tối đa 300 giây (5 phút)
    $leeway = 300; 
    $verifiedIdToken = $auth->verifyIdToken($idToken, false, $leeway);
    $claims = $verifiedIdToken->claims();
    $email = $claims->get('email');
    $name = $claims->get('name') ?? $email;

    // 7. Xử lý Logic Database
    $email_escaped = mysqli_real_escape_string($conn, $email);
    $sql_check = "SELECT * FROM khachhang WHERE email = '$email_escaped' LIMIT 1";
    $result_check = mysqli_query($conn, $sql_check);

    if ($result_check && mysqli_num_rows($result_check) > 0) {
        // --- ĐĂNG NHẬP ---
        $row = mysqli_fetch_assoc($result_check);
        $_SESSION['khachhang'] = [
            'id_khachhang'  => $row['id_khachhang'],
            'ten_khachhang' => $row['ten_khachhang'],
            'email'         => $row['email'],
            'so_dien_thoai' => $row['so_dien_thoai'],
            'dia_chi'       => $row['dia_chi']
        ];
        $response['success'] = true;
        $response['message'] = 'Đăng nhập thành công.';
    } else {
        // --- ĐĂNG KÝ MỚI ---
        $name_escaped = mysqli_real_escape_string($conn, $name);
        $random_password = password_hash(bin2hex(random_bytes(8)), PASSWORD_BCRYPT);

        // Lưu ý: Cột so_dien_thoai, dia_chi để trống vì Firebase không trả về
        $sql_insert = "INSERT INTO khachhang (ten_khachhang, email, mat_khau, so_dien_thoai, dia_chi) 
                       VALUES ('$name_escaped', '$email_escaped', '$random_password', '', '')";

        if (mysqli_query($conn, $sql_insert)) {
            $new_id = mysqli_insert_id($conn);
            $_SESSION['khachhang'] = [
                'id_khachhang'  => $new_id,
                'ten_khachhang' => $name,
                'email'         => $email,
                'so_dien_thoai' => '',
                'dia_chi'       => ''
            ];
            $response['success'] = true;
            $response['message'] = 'Đăng ký thành công.';
        } else {
            $response['message'] = 'Lỗi MySQL: ' . mysqli_error($conn);
        }
    }

} catch (InvalidToken $e) {
    $response['message'] = 'Token không hợp lệ: ' . $e->getMessage();
} catch (\Throwable $e) {
    $response['message'] = 'Lỗi hệ thống: ' . $e->getMessage();
}

echo json_encode($response);
exit;
?>