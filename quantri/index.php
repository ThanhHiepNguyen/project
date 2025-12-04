<?php
	session_start();
	//include_once('./cauhinh/ketnoi.php');
	require "../cauhinh/ketnoi.php";
	$error = NULL;
	if(isset($_POST['submit'])){
		if($_POST['tk']==""){
			$error = "Vui lòng nhập tài khoản và mật khẩu";
		}else{
			$tk = $_POST['tk'];
		}

		if($_POST['mk']==""){
			$error = "Vui lòng nhập tài khoản và mật khẩu";
		}else{
			$mk = $_POST['mk'];
		}

		if(isset($tk) && isset($mk)){
            // Lấy theo email, sau đó kiểm tra mật khẩu (hỗ trợ cả dạng hash và dạng cũ lưu plain-text)
			$tk_escaped = mysqli_real_escape_string($conn, $tk);
			$sql = "SELECT * FROM thanhvien WHERE email = '$tk_escaped' LIMIT 1";
			$query = mysqli_query($conn, $sql);

			if(!$query || mysqli_num_rows($query) === 0){
				$error = 'Tài khoản hoặc mật khẩu chưa đúng';
			}else{
				$user = mysqli_fetch_assoc($query);
                $hash = $user['mat_khau'];

                // Đúng nếu: (1) mật khẩu đang lưu dạng hash và verify ok, hoặc (2) hệ cũ lưu plain-text trùng mk
                $isValidPassword = password_verify($mk, $hash) || ($mk === $hash);

                if (!$isValidPassword) {
                    $error = 'Tài khoản hoặc mật khẩu chưa đúng';
                } else {
                    $_SESSION['tk'] = $tk;
                    $_SESSION['mk'] = $mk;
                    $_SESSION['vai_tro'] = isset($user['vai_tro']) ? $user['vai_tro'] : 'nhan_vien';
                    header('location:quantri.php');
                    exit;
                }
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8" />
	<title>Shop Thu Minh - Đăng nhập quản trị</title>
	<link rel="stylesheet" type="text/css" href="css/dangnhap.css" />
</head>
<body>
	<?php
		if(!isset($_SESSION['tk'])){


	?>
	<form method="post">
	<div id="form-login">
		<h2>Đăng nhập hệ thống quản trị</h2>
		<center><span style="color:red;"><?php echo $error;?></span></center>
	    <ul>
	        <li><label>Tài khoản</label><input type="text" name="tk" /></li>
	        <li><label>Mật khẩu</label><input type="password" name="mk" /></li>
	        <li><label>Ghi nhớ <input type="checkbox" name="check" checked="checked" /></label></li>
	        <li><input type="submit" name="submit" value="Đăng nhập" /> <input type="reset" name="resset" value="Làm mới" /></li>
	    </ul>
	</div>
	</form>
	<?php
}else{
	header('location:quantri.php');
}
	?>
</body>
</html>
