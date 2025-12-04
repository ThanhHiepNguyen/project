<?php
ob_start();
// Kết nối tới cơ sở dữ liệu
require "cauhinh/ketnoi.php";

// Khởi tạo biến để lưu thông báo lỗi cho từng trường
$ten_error = $mail_error = $dt_error = $dc_error = '';

// Xử lý yêu cầu form mua ngay
if (isset($_POST['submit'])) {
    // Lưu thông tin đơn hàng vào bảng donhang
    $ten = $_POST['ten'];
    $mail = $_POST['mail'];
    $dt = $_POST['dt'];
    $dc = $_POST['dc'];
    $id_sp = $_POST['id_sp'];
    $phuong_thuc_thanh_toan = $_POST['phuong_thuc_thanh_toan'];
    
    // Kiểm tra dữ liệu
    $has_error = false;

    if (empty($ten)) {
        $ten_error = 'Vui lòng nhập tên khách hàng.';
        $has_error = true;
    }

    if (empty($mail)) {
        $mail_error = 'Vui lòng nhập địa chỉ email.';
        $has_error = true;
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $mail_error = 'Địa chỉ email không hợp lệ.';
        $has_error = true;
    }

   
    if (empty($dt)) {
        $dt_error = 'Vui lòng nhập số điện thoại.';
        $has_error = true;
    } elseif (!ctype_digit($dt)) {
        $dt_error = 'Số điện thoại chỉ được chứa các chữ số.';
        $has_error = true;
    } elseif (strlen($dt) < 9 || strlen($dt) > 10) {
        $dt_error = 'Độ dài số điện thoại không hợp lệ.';
        $has_error = true;
    }

    
    if (empty($dc)) {
        $dc_error = 'Vui lòng nhập địa chỉ nhận hàng.';
        $has_error = true;
    }

    // Nếu không có lỗi, tiến hành xử lý đơn hàng
    if (!$has_error){
        $tong_gia = 0;

        // Lấy thông tin sản phẩm
        $sql = "SELECT gia_sp, so_luong FROM sanpham WHERE id_sp = $id_sp";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $gia_sp = $row['gia_sp'];
        $so_luong_con_lai = $row['so_luong'] - 1; // Cập nhật số lượng sản phẩm

        // Kiểm tra xem có đủ hàng không
        if ($so_luong_con_lai < 0) {
            echo 'Sản phẩm này đã hết hàng.';
            exit();
        }

        // Cập nhật số lượng sản phẩm
        $sql = "UPDATE sanpham SET so_luong = $so_luong_con_lai WHERE id_sp = $id_sp";
        mysqli_query($conn, $sql);

        $tong_gia = $gia_sp; // Chỉ có 1 sản phẩm

        // Thực hiện insert vào bảng donhang
        $sql = "INSERT INTO donhang (ten_khachhang, email, so_dien_thoai, dia_chi, tong_gia, phuong_thuc_thanh_toan) 
                VALUES ('$ten', '$mail', '$dt', '$dc', $tong_gia, '$phuong_thuc_thanh_toan')";
        mysqli_query($conn, $sql);
        $id_donhang = mysqli_insert_id($conn); // Lấy id đơn hàng vừa tạo

        // Thực hiện insert vào bảng chitiet_donhang
        $ten_sanpham = $_POST['ten_sanpham'];
        $thanh_tien = $gia_sp; // Chỉ có 1 sản phẩm, số lượng = 1

        $sql = "INSERT INTO chitiet_donhang (id_donhang, id_sanpham, ten_sanpham, gia, so_luong, thanh_tien) 
                VALUES ($id_donhang, $id_sp, '$ten_sanpham', $gia_sp, 1, $thanh_tien)";
        mysqli_query($conn, $sql);

        // Redirect sau khi xử lý form (dùng JS để tránh lỗi header already sent)
        echo '<script>window.location.href="index.php?page_layout=hoanthanh";</script>';
        exit(); // Đảm bảo thoát sau khi điều hướng
    }  
    ob_end_flush();  
}

// Nếu khách đã đăng nhập và chưa submit, tự động điền thông tin mặc định
if (!isset($ten) && isset($_SESSION['khachhang'])) {
    $ten  = $_SESSION['khachhang']['ten_khachhang'] ?? '';
    $mail = $_SESSION['khachhang']['email'] ?? '';
    $dt   = $_SESSION['khachhang']['so_dien_thoai'] ?? '';
    $dc   = $_SESSION['khachhang']['dia_chi'] ?? '';
}

// Nếu không có form POST, lấy ID sản phẩm từ URL và hiển thị form
$id_sp = intval($_GET['id_sp']);
$sql = "SELECT * FROM sanpham WHERE id_sp = $id_sp";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8 pb-4 border-b-2 border-blue-600">
        Xác nhận hóa đơn thanh toán
    </h2>

    <!-- Invoice Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Tên Sản phẩm</th>
                        <th class="px-6 py-4 text-center font-semibold">Giá</th>
                        <th class="px-6 py-4 text-center font-semibold">Số lượng</th>
                        <th class="px-6 py-4 text-right font-semibold">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 font-medium text-gray-800"><?php echo htmlspecialchars($product['ten_sp']); ?></td>
                        <td class="px-6 py-4 text-center text-gray-600"><?php echo number_format($product['gia_sp'], 0, ',', '.') ?>₫</td>
                        <td class="px-6 py-4 text-center text-gray-600">1</td>
                        <td class="px-6 py-4 text-right font-bold text-blue-600"><?php echo number_format($product['gia_sp'], 0, ',', '.') ?>₫</td>
                    </tr>
                    <tr class="bg-gradient-to-r from-blue-50 to-blue-100 font-bold">
                        <td class="px-6 py-4 text-lg">Tổng giá trị hóa đơn:</td>
                        <td colspan="2"></td>
                        <td class="px-6 py-4 text-right text-xl text-blue-600"><?php echo number_format($product['gia_sp'], 0, ',', '.') ?>₫</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Information Form -->
    <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 pb-3 border-b border-gray-200">
            Thông tin khách hàng
        </h3>
        <form method="post" class="space-y-6">
            <input type="hidden" name="id_sp" value="<?php echo $product['id_sp']; ?>" />
            <input type="hidden" name="ten_sanpham" value="<?php echo htmlspecialchars($product['ten_sp']); ?>" />
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tên khách hàng <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="ten" 
                       value="<?php echo isset($ten) ? htmlspecialchars($ten) : ''; ?>" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                <?php if (!empty($ten_error)): ?>
                    <div class="mt-1 text-sm text-red-600"><?php echo $ten_error; ?></div>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Địa chỉ Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="mail" 
                       value="<?php echo isset($mail) ? htmlspecialchars($mail) : ''; ?>" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                <?php if (!empty($mail_error)): ?>
                    <div class="mt-1 text-sm text-red-600"><?php echo $mail_error; ?></div>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Số Điện thoại <span class="text-red-500">*</span>
                </label>
                <input type="tel" 
                       name="dt" 
                       value="<?php echo isset($dt) ? htmlspecialchars($dt) : ''; ?>" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                <?php if (!empty($dt_error)): ?>
                    <div class="mt-1 text-sm text-red-600"><?php echo $dt_error; ?></div>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Địa chỉ nhận hàng <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="dc" 
                       value="<?php echo isset($dc) ? htmlspecialchars($dc) : ''; ?>" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                <?php if (!empty($dc_error)): ?>
                    <div class="mt-1 text-sm text-red-600"><?php echo $dc_error; ?></div>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Phương thức thanh toán <span class="text-red-500">*</span>
                </label>
                <select name="phuong_thuc_thanh_toan" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 bg-white">
                    <option value="Tiền mặt" <?php echo isset($phuong_thuc_thanh_toan) && $phuong_thuc_thanh_toan == 'Tiền mặt' ? 'selected' : ''; ?>>Tiền mặt</option>
                    <option value="Chuyển khoản ngân hàng" <?php echo isset($phuong_thuc_thanh_toan) && $phuong_thuc_thanh_toan == 'Chuyển khoản ngân hàng' ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                    <option value="Ví MOMO" <?php echo isset($phuong_thuc_thanh_toan) && $phuong_thuc_thanh_toan == 'Ví MOMO' ? 'selected' : ''; ?>>Ví MOMO</option>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit" 
                        name="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-lg hover:shadow-xl">
                    Xác nhận mua hàng
                </button>
                <button type="reset" 
                        name="reset" 
                        class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition-colors duration-200">
                    Làm lại
                </button>
            </div>
        </form>
    </div>
</div>
