<?php
ob_start();
require "../cauhinh/ketnoi.php";
$id_sp = $_GET['id_sp'];
$sql = "SELECT * FROM sanpham WHERE id_sp = $id_sp";
$query = mysqli_query($conn, $sql);
$arr = mysqli_fetch_array($query);
?>

<link rel="stylesheet" type="text/css" href="css/themsp.css" />
<h2>Sửa thông tin sản phẩm</h2>
<div id="main">
    <form method="post" enctype="multipart/form-data">
        <table id="add-prd" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <label>Tên sản phẩm</label><br />
                    <input type="text" name="ten_sp" value="<?php echo isset($_POST['ten_sp']) ? $_POST['ten_sp'] : $arr['ten_sp']; ?>" />
                    <?php if (isset($error_ten_sp)) { echo $error_ten_sp; } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Ảnh mô tả (upload file)</label><br />
                    <?php if (!empty($arr['anh_sp'])): ?>
                        <?php
                        // Xử lý đường dẫn ảnh hiện tại cho đúng trong trang admin
                        $currentImg = $arr['anh_sp'];
                        if (preg_match('/^https?:\/\//', $currentImg)) {
                            // Link tuyệt đối (http/https)
                            $currentImgSrc = $currentImg;
                        } elseif (strpos($currentImg, '/') === 0) {
                            // Đã là đường dẫn tuyệt đối trên server (bắt đầu bằng /)
                            $currentImgSrc = $currentImg;
                        } else {
                            // Đường dẫn tương đối trong project (vd: anh/ten-anh.jpg)
                            // Admin đang ở thư mục quantri → cần ../ để ra gốc project
                            $currentImgSrc = '../' . $currentImg;
                        }
                        ?>
                        <p>Ảnh hiện tại:</p>
                        <img src="<?php echo htmlspecialchars($currentImgSrc); ?>" alt="Ảnh hiện tại" style="max-width:150px; max-height:150px; display:block; margin-bottom:8px;" />
                    <?php endif; ?>
                    <input type="file" name="anh_sp" accept="image/*" />
                    <p style="font-size:12px;color:#555;">Nếu không chọn ảnh mới, hệ thống sẽ giữ nguyên ảnh cũ.</p>
                    <?php if (isset($error_anh_sp)) { echo $error_anh_sp; } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Danh mục sản phẩm</label><br />
                    <select name="id_dm">
                        <?php
                        $sqlDm = "SELECT * FROM dmsanpham";
                        $queryDm = mysqli_query($conn, $sqlDm);
                        while ($arrDm = mysqli_fetch_array($queryDm)) {
                            $selected = $arrDm['id_dm'] == $arr['id_dm'] ? 'selected' : '';
                            echo "<option value='{$arrDm['id_dm']}' $selected>{$arrDm['ten_dm']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Giá sản phẩm</label><br />
                    <input type="text" name="gia_sp" value="<?php echo isset($_POST['gia_sp']) ? $_POST['gia_sp'] : $arr['gia_sp']; ?>" />
                    <?php if (isset($error_gia_sp)) { echo $error_gia_sp; } ?> VNĐ
                </td>
            </tr>
            <tr>
                <td>
                    <label>Khuyến mại</label><br />
                    <input type="text" name="khuyen_mai" value="<?php echo isset($_POST['khuyen_mai']) ? $_POST['khuyen_mai'] : $arr['khuyen_mai']; ?>" />
                    <?php if (isset($error_khuyen_mai)) { echo $error_khuyen_mai; } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Còn hàng</label><br />
                    <input type="text" name="trang_thai" value="<?php echo isset($_POST['trang_thai']) ? $_POST['trang_thai'] : $arr['trang_thai']; ?>" />
                    <?php if (isset($error_trang_thai)) { echo $error_trang_thai; } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Số lượng sản phẩm</label><br />
                    <input type="text" name="so_luong" value="<?php echo isset($_POST['so_luong']) ? $_POST['so_luong'] : $arr['so_luong']; ?>" />
                    <?php if (isset($error_so_luong)) { echo $error_so_luong; } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Sản phẩm đặc biệt</label><br />
                    Có <input type="radio" name="dac_biet" value="1" <?php if ($arr['dac_biet'] == 1) echo 'checked'; ?> />
                    Không <input type="radio" name="dac_biet" value="0" <?php if ($arr['dac_biet'] == 0) echo 'checked'; ?> />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Thông tin chi tiết sản phẩm</label><br />
                    <textarea cols="60" rows="12" name="chi_tiet_sp"><?php echo isset($_POST['chi_tiet_sp']) ? $_POST['chi_tiet_sp'] : $arr['chi_tiet_sp']; ?></textarea>
                    <?php if (isset($error_chi_tiet_sp)) { echo $error_chi_tiet_sp; } ?>
                </td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Cập nhật" /> <input type="reset" name="reset" value="Làm mới" /></td>
            </tr>
        </table>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $error = false;

    // Tên sản phẩm
    if (empty($_POST['ten_sp'])) {
        $error_ten_sp = '<span style="color:red;">(*)</span>';
        $error = true;
    } else {
        $ten_sp = $_POST['ten_sp'];
    }

    // Giá sản phẩm (bắt buộc)
    if (empty($_POST['gia_sp'])) {
        $error_gia_sp = '<span style="color:red;">(*)</span>';
        $error = true;
    } else {
        $gia_sp = $_POST['gia_sp'];
    }

    // Khuyến mãi (cho phép để trống)
    if (isset($_POST['khuyen_mai'])) {
        $khuyen_mai = $_POST['khuyen_mai'];
    } else {
        $khuyen_mai = '';
    }

    // Trạng thái (cho phép để trống)
    if (isset($_POST['trang_thai'])) {
        $trang_thai = $_POST['trang_thai'];
    } else {
        $trang_thai = '';
    }

    // Số lượng sản phẩm (mặc định 0 nếu trống)
    if ($_POST['so_luong'] === '' || $_POST['so_luong'] === null) {
        $so_luong = 0;
    } elseif (!is_numeric($_POST['so_luong']) || $_POST['so_luong'] < 0) {
        $error_so_luong = '<span style="color:red;">Vui lòng nhập số lượng sản phẩm hợp lệ</span>';
        $error = true;
    } else {
        $so_luong = $_POST['so_luong'];
    }

    // Chi tiết sản phẩm (cho phép để trống)
    if (isset($_POST['chi_tiet_sp'])) {
        $chi_tiet_sp = $_POST['chi_tiet_sp'];
    } else {
        $chi_tiet_sp = '';
    }

    // Ảnh mô tả sản phẩm (upload file, có thể giữ ảnh cũ)
    if (isset($_FILES['anh_sp']) && $_FILES['anh_sp']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['anh_sp']['error'] !== UPLOAD_ERR_OK) {
            $error_anh_sp = '<span style="color:red;">Có lỗi khi upload ảnh sản phẩm</span>';
            $error = true;
        } else {
            $uploadDir = '../anh/';
            $fileName = basename($_FILES['anh_sp']['name']);
            $fileName = preg_replace('/[^A-Za-z0-9_\.\-]/', '_', $fileName);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['anh_sp']['tmp_name'], $targetPath)) {
                $anh_sp = 'anh/' . $fileName;
            } else {
                $error_anh_sp = '<span style="color:red;">Không thể lưu file ảnh sản phẩm</span>';
                $error = true;
            }
        }
    } else {
        // Không chọn ảnh mới -> giữ nguyên ảnh cũ
        $anh_sp = $arr['anh_sp'];
    }

    // Danh mục sản phẩm
    $id_dm = $_POST['id_dm'];

    // Sản phẩm đặc biệt
    $dac_biet = $_POST['dac_biet'];

    // Xử lý cập nhật thông tin sản phẩm
    if (!$error) {
        $sqlUpdate = "UPDATE sanpham SET 
                      id_dm = '$id_dm', 
                      ten_sp = '$ten_sp', 
                      anh_sp = '$anh_sp', 
                      gia_sp = '$gia_sp', 
                      khuyen_mai = '$khuyen_mai', 
                      trang_thai = '$trang_thai', 
                      so_luong = '$so_luong', 
                      dac_biet = '$dac_biet', 
                      chi_tiet_sp = '$chi_tiet_sp' 
                      WHERE id_sp = $id_sp";
        
        $queryUpdate = mysqli_query($conn, $sqlUpdate);
        if ($queryUpdate) {
            header('location:quantri.php?page_layout=danhsachsp');
            exit;
        } else {
            echo '<p style="color:red;">Lỗi SQL: ' . htmlspecialchars(mysqli_error($conn)) . '</p>';
        }
    }
}

ob_end_flush();
?>
