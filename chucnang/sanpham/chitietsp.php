<link rel="stylesheet" type="text/css" href="css/chitietsp.css" />
<div class="prd-block">
    <div class="prd-only">
        <?php
        $id_sp = isset($_GET['id_sp']) ? (int)$_GET['id_sp'] : 0;
        $sql = "SELECT * FROM sanpham WHERE id_sp = $id_sp";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
        $so_luong = $row['so_luong']; // Lấy số lượng sản phẩm

        // Lấy thông số kỹ thuật sản phẩm (nếu có)
        $tskt = [];
        if ($id_sp > 0) {
            $sql_ts = "SELECT ten_thong_so, gia_tri FROM thong_so_ky_thuat WHERE id_sanpham = $id_sp";
            $query_ts = mysqli_query($conn, $sql_ts);
            if ($query_ts) {
                while ($row_ts = mysqli_fetch_assoc($query_ts)) {
                    $tskt[] = $row_ts;
                }
            }
        }

        // Lưu bình luận sản phẩm (nếu có gửi form)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $ten_bl       = trim($_POST['ten'] ?? '');
            $dien_thoai   = trim($_POST['dien_thoai'] ?? '');
            $noi_dung_bl  = trim($_POST['binh_luan'] ?? '');

            if ($noi_dung_bl !== '') {
                if ($ten_bl === '' && isset($_SESSION['khachhang'])) {
                    $ten_bl = $_SESSION['khachhang']['ten_khachhang'];
                }
                if ($ten_bl === '') {
                    $ten_bl = 'Khách hàng ẩn danh';
                }

                $ten_esc      = mysqli_real_escape_string($conn, $ten_bl);
                $dt_esc       = mysqli_real_escape_string($conn, $dien_thoai);
                $noidung_esc  = mysqli_real_escape_string($conn, $noi_dung_bl);

                $sql_insert_bl = "
                    INSERT INTO blsanpham (id_sp, ten, dien_thoai, binh_luan, ngay_gio)
                    VALUES ($id_sp, '$ten_esc', '$dt_esc', '$noidung_esc', NOW())
                ";
                mysqli_query($conn, $sql_insert_bl);

                // Tránh submit lại khi F5
                echo '<script>window.location.href = "index.php?page_layout=chitietsp&id_sp=' . $id_sp . '";</script>';
                exit;
            }
        }

        // Kiểm tra sản phẩm có nằm trong yêu thích của khách hiện tại không
        $is_favorite = false;
        if (isset($_SESSION['khachhang']) && $id_sp > 0) {
            $id_khachhang = (int)$_SESSION['khachhang']['id_khachhang'];
            $sql_fav = "SELECT id_yeu_thich FROM yeu_thich WHERE id_khachhang = $id_khachhang AND id_sanpham = $id_sp LIMIT 1";
            $res_fav = mysqli_query($conn, $sql_fav);
            if ($res_fav && mysqli_num_rows($res_fav) > 0) {
                $is_favorite = true;
            }
        }
        ?>

        <div class="prd-img" style="position: relative;">
            <div id="slide">
                <img id="hinh" style="width: 400px;height: 400px;margin-top:5px;margin-left:50px;" src="<?php echo htmlspecialchars($row['anh_sp']); ?>" />
                <i class="fa fa-chevron-circle-left" style="position:absolute;top:25%;left:50px;font-size: 30px;color:#b29696" onclick="prev()"></i>
                <i class="fa fa-chevron-circle-right" style="position:absolute;top:25%;right:21px;font-size: 30px;color:#b29696" onclick="next()"></i>
                <div class="small-img" style="width: 160%;margin-top:30px;margin-left:75px;">
                    <img src="<?php echo htmlspecialchars($row['anh_sp']); ?>" onclick="TransPhoto(this)">
                    <img src="<?php echo htmlspecialchars($row['anh_sp']); ?>" onclick="TransPhoto(this)">
                    <img src="<?php echo htmlspecialchars($row['anh_sp']); ?>" onclick="TransPhoto(this)">
                    <img src="<?php echo htmlspecialchars($row['anh_sp']); ?>" onclick="TransPhoto(this)">
                </div>
            </div>
            <div class="rating-box">
                <h3 style="text-align: center;">Đánh giá sản phẩm</h3>
                <div class="rating-info">
                    <span class="rating-score">5/5</span>
                    <span class="rating-text">Tổng số 04 lượt đánh giá</span>
                    <div class="stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                </div>
                <div class="like-info">
                    <i class="fa fa-thumbs-up"></i>
                    <span class="like-count">04</span>
                    <span class="like-text">Đánh giá yêu thích sản phẩm này</span>
                </div>
            </div>
            <div class="rating-bar">
                <div class="rating-row">
                    <div class="rating-label">5 Sao</div>
                    <div class="rating-bar-fill">
                        <div class="rating-fill" style="width: 100%;">100%</div>
                    </div>
                </div>
                <div class="rating-row">
                    <div class="rating-label">4 Sao</div>
                    <div class="rating-bar-fill">
                        <div class="rating-fill empty" style="width: 0%;">0%</div>
                    </div>
                </div>
                <div class="rating-row">
                    <div class="rating-label">3 Sao</div>
                    <div class="rating-bar-fill">
                        <div class="rating-fill empty" style="width: 0%;">0%</div>
                    </div>
                </div>
                <div class="rating-row">
                    <div class="rating-label">2 Sao</div>
                    <div class="rating-bar-fill">
                        <div class="rating-fill empty" style="width: 0%;">0%</div>
                    </div>
                </div>
                <div class="rating-row">
                    <div class="rating-label">1 Sao</div>
                    <div class="rating-bar-fill">
                        <div class="rating-fill empty" style="width: 0%;">0%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 prd-intro" style="margin-left: 100px;margin-right:50px">
            <h3 style="border-bottom:1px dashed black;margin-bottom: 20px;text-align: center;"><?php echo htmlspecialchars($row['ten_sp']); ?></h3>
            <p style="line-height:2em;text-align: justify;"><?php echo nl2br(htmlspecialchars($row['chi_tiet_sp'])); ?></p>
            <p>Giá sản phẩm: <span><?php echo number_format($row['gia_sp'], 0, ',', '.') ?> VNĐ</span></p>
            <p>Khuyến mãi: <span><?php echo htmlspecialchars($row['khuyen_mai']); ?></span></p>

            <?php if (!empty($tskt)): ?>
            <h4 style="margin-top: 20px; font-weight: bold;">Thông số kỹ thuật</h4>
            <table style="width:100%; border-collapse: collapse; margin-top:10px;">
                <tbody>
                <?php foreach ($tskt as $ts): ?>
                    <tr>
                        <td style="border:1px solid #ddd; padding:8px; width:40%; font-weight:600;">
                            <?php echo htmlspecialchars($ts['ten_thong_so']); ?>
                        </td>
                        <td style="border:1px solid #ddd; padding:8px;">
                            <?php echo htmlspecialchars($ts['gia_tri']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <!-- Hiển thị số lượng sản phẩm -->
            <p>Số lượng:
                <?php if ($so_luong > 0): ?>
                    <span><?php echo $so_luong ?> sản phẩm có sẵn</span>
                <?php else: ?>
                    <span class="out-of-stock">Sản phẩm này hiện không có sẵn</span>
                <?php endif; ?>
            </p>
            <hr>
            <div style="margin-top: 30px;text-align: center;">
                <a href="javascript:void(0);" onclick="checkStockAndProceed(<?php echo $so_luong; ?>, 'chucnang/giohang/themhang.php?id_sp=<?php echo $row['id_sp']; ?>')">
                    <button type="button" class="btn-success">Thêm vào giỏ hàng</button>
                </a>

                <a href="javascript:void(0);" onclick="checkStockAndProceed(<?php echo $so_luong; ?>, 'index.php?page_layout=muahangtructiep&id_sp=<?php echo $row['id_sp']; ?>')">
                    <button type="button" class="btn-success">Mua ngay</button>
                </a>
                <?php if (isset($_SESSION['khachhang'])): ?>
                    <a href="chucnang/yeuthich/toggle.php?id_sp=<?php echo $row['id_sp']; ?>&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                       style="margin-left: 10px; display:inline-block;">
                        <button type="button" class="btn-success" style="background-color:#f97373;border-color:#f97373;">
                            <?php echo $is_favorite ? 'Bỏ yêu thích' : 'Thêm vào yêu thích'; ?>
                        </button>
                    </a>
                <?php endif; ?>
            </div>
            <div style="border: 1px solid #a49a9a4f;border-radius: 10px;margin-top: 50px;">
                <div style="display: block;padding:5px;background-color: #a49a9a4f;border-top-left-radius: 10px;
                border-top-right-radius: 10px;">
                    <a>
                        <span>
                            <span>
                                <i class="fa fa-gift" aria-hidden="true" style="font-size: 20px;"></i>
                            </span>
                            <span>PHỤ KIỆN KÈM THEO - SỐ LƯỢNG CÓ HẠN</span>
                        </span>
                    </a>
                </div>

                <table style="border:1px solid #a49a9a4f;padding: 15px 10px;border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;">
                    <tr>
                        <td style="border:1px solid #a49a9a4f">
                            <div style="display: flex;">
                                <figure>
                                    <img style="border-radius: 10px;margin-left: 10px;" width="120" height="120" src="https://lili.vn/wp-content/uploads/2020/10/Anh-hop-san-pham-LiLi-Final-400x400.jpg">
                                </figure>
                                <div>
                                    <h3 style="color: #000;font-family:Open Sans,Sans-serif;font-size: 16px;font-weight: 500;margin-top: 50px;margin-left: 20px;">Bộ đóng gói chuyên nghiệp</h3>
                                </div>
                            </div>
                        </td>


                        <td style="border:1px solid #a49a9a4f">
                            <div style="display: flex;">
                                <figure class="elementor-image-box-img">
                                    <img width="120" height="120" src="https://lili.vn/wp-content/uploads/2022/05/Hop-dung-trang-suc-boc-da-vuong-mien-Royal-LILI_719713_1-400x400.jpg">
                                </figure>
                                <div>
                                    <h3 style="color: #000;font-family:Open Sans,Sans-serif;font-size: 16px;font-weight: 500;margin-top: 50px;margin-left: 20px;">Bộ dụng cụ sửa chữa chuyên nghiệp</h3>
                                </div>
                            </div>
                        </td>

                    </tr>
                    <tr style="border:1px solid #a49a9a4f">
                        <td style="border:1px solid #a49a9a4f">
                            <div style="display: flex;">
                                <figure class="elementor-image-box-img">
                                    <img width="120" height="120" src="https://lili.vn/wp-content/uploads/2020/10/Hop-dung-do-trang-suc-mini-nam-nu-trang-boc-da-Zelda-LILI_878639_10-400x400.jpg">
                                </figure>
                                <div>
                                    <h3 style="color: #000;font-family:Open Sans,Sans-serif;font-size: 16px;font-weight: 500;margin-top: 50px;margin-left: 20px;">Bộ phụ tùng đa năng cao cấp</h3>
                                </div>
                            </div>
                        </td>

                        <td style="border:1px solid #a49a9a4f">
                            <div style="display: flex;">
                                <figure class="elementor-image-box-img">
                                    <img width="120" height="120" src="https://lili.vn/wp-content/uploads/2020/10/Qua-tang-bi-mat-dac-biet-5-400x400.png">
                                </figure>
                                <div>
                                    <h3 style="color: #000;font-family:Open Sans,Sans-serif;font-size: 16px;font-weight: 500;margin-top: 50px;margin-left: 20px;">Quà tặng đặc biệt khi mua hàng</h3>
                                </div>
                            </div>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <?php
    // Lấy danh sách bình luận cho sản phẩm
    $ds_binhluan = [];
    $sql_bl = "SELECT * FROM blsanpham WHERE id_sp = $id_sp ORDER BY ngay_gio DESC";
    $query_bl = mysqli_query($conn, $sql_bl);
    if ($query_bl) {
        while ($row_bl = mysqli_fetch_assoc($query_bl)) {
            $ds_binhluan[] = $row_bl;
        }
    }
    $tong_bl = count($ds_binhluan);
    ?>

    <div class="prd-comment" style="margin-top: 40px; background:#fff; border-radius:12px; border:1px solid #e5e7eb; padding:20px 24px;">
        <div style="max-width: 960px; margin: 0 auto;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <h3 style="font-size:20px; font-weight:700; margin:0; color:#111827;">Bình luận</h3>
                <span style="font-size:13px; color:#6b7280;">
                    <?php echo $tong_bl; ?> bình luận
                </span>
            </div>

            <!-- Ô nhập bình luận kiểu Facebook/Shopee -->
            <form method="post">
                <!-- Ẩn các field tên/điện thoại, vẫn giữ name để backend dùng được -->
                <input type="hidden" name="ten" value="<?php echo isset($_SESSION['khachhang']['ten_khachhang']) ? htmlspecialchars($_SESSION['khachhang']['ten_khachhang']) : ''; ?>">
                <input type="hidden" name="dien_thoai" value="">

                <div style="display:flex; align-items:flex-start; gap:12px;">
                    <!-- Avatar tròn với chữ cái đầu tên -->
                    <div style="flex-shrink:0; width:36px; height:36px; border-radius:999px; background:#e5e7eb; display:flex; align-items:center; justify-content:center; font-size:15px; font-weight:600; color:#374151;">
                        <?php
                        if (isset($_SESSION['khachhang'])) {
                            $name_cmt = trim($_SESSION['khachhang']['ten_khachhang']);
                            $initial_cmt = mb_substr($name_cmt, 0, 1, 'UTF-8');
                            echo htmlspecialchars(mb_strtoupper($initial_cmt));
                        } else {
                            echo 'G';
                        }
                        ?>
                    </div>

                    <div style="flex:1; display:flex; align-items:center; gap:12px; background:#f3f4f6; border-radius:999px; padding:6px 10px 6px 16px; border:1px solid transparent;">
                        <textarea
                            required
                            name="binh_luan"
                            rows="1"
                            placeholder="Nhập nội dung bình luận..."
                            style="flex:1; border:none; background:transparent; resize:none; outline:none; font-size:14px; padding:6px 0; max-height:80px;"
                            oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                        ></textarea>

                        <button
                            type="submit"
                            name="submit"
                            style="flex-shrink:0; padding:7px 16px; border-radius:999px; border:none; background:#111827; color:#fff; font-size:14px; font-weight:600; cursor:pointer;"
                        >
                            Gửi bình luận
                        </button>
                    </div>
                </div>
            </form>

            <?php if ($tong_bl > 0): ?>
                <div class="comment-list" style="margin-top: 24px;">
                    <?php foreach ($ds_binhluan as $bl): ?>
                        <div style="display:flex; gap:12px; padding:10px 0; border-top:1px solid #e5e7eb;">
                            <div style="flex-shrink:0; width:32px; height:32px; border-radius:999px; background:#e5e7eb; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:600; color:#374151;">
                                <?php
                                $initial_bl = mb_substr($bl['ten'], 0, 1, 'UTF-8');
                                echo htmlspecialchars(mb_strtoupper($initial_bl));
                                ?>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:14px; font-weight:600; color:#111827;">
                                    <?php echo htmlspecialchars($bl['ten']); ?>
                                    <span style="font-size:12px; color:#9ca3af; margin-left:4px;">
                                        <?php echo date('d/m/Y H:i', strtotime($bl['ngay_gio'])); ?>
                                    </span>
                                </div>
                                <div style="margin-top:4px; font-size:14px; color:#111827; white-space:pre-line;">
                                    <?php echo nl2br(htmlspecialchars($bl['binh_luan'])); ?>
                                </div>

                                <?php if (!empty($bl['phan_hoi_admin'] ?? '')): ?>
                                    <div style="margin-top:8px; padding:8px 10px; background:#f3f4ff; border-radius:8px; font-size:13px; color:#1f2937;">
                                        <span style="font-weight:600; color:#1d4ed8;">Quản trị viên</span>
                                        <span style="margin:0 4px;">•</span>
                                        <span><?php echo nl2br(htmlspecialchars($bl['phan_hoi_admin'])); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    </div>
</div>


<script>
    function checkStockAndProceed(stock, url) {
        if (stock > 0) {
            window.location.href = url;
        } else {
            alert('Sản phẩm này hiện không có sẵn');
        }
    }
</script>
<script>
    var arr_hinh = [
        "<?php echo htmlspecialchars($row['anh_sp']); ?>",
        "<?php echo htmlspecialchars($row['anh_sp']); ?>",
        "<?php echo htmlspecialchars($row['anh_sp']); ?>",
        "<?php echo htmlspecialchars($row['anh_sp']); ?>"
    ]

    var index = 0;

    function next() {
        index++;
        if (index >= arr_hinh.length) index = 0;

        var hinh = document.getElementById("hinh");
        hinh.src = arr_hinh[index];
    }

    function prev() {
        index--;
        if (index < 0) index = arr_hinh.length - 1;

        var hinh = document.getElementById("hinh");
        hinh.src = arr_hinh[index];
    }

    function TransPhoto(smallImg) {
        var allImg = document.getElementById("hinh");
        allImg.src = smallImg.src;
    }
</script>