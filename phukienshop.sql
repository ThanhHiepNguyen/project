SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Tạo bảng `dmsanpham` (Danh mục sản phẩm)
-- --------------------------------------------------------
CREATE TABLE `dmsanpham` (
  `id_dm` int(10) NOT NULL AUTO_INCREMENT,
  `ten_dm` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_dm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chèn dữ liệu vào bảng `dmsanpham`
INSERT INTO `dmsanpham` (`id_dm`, `ten_dm`) VALUES
(1, 'Phụ tùng gầm'),
(2, 'Phụ tùng động cơ'),
(3, 'Phụ tùng điện lạnh'),
(4, 'Phụ tùng thân vỏ'),
(5, 'Dầu nhờn - Phụ gia ô tô'),
(6, 'Phụ tùng nội thất');

-- --------------------------------------------------------
-- Tạo bảng `dmphutung_con` (Danh mục phụ tùng con)
-- --------------------------------------------------------
CREATE TABLE `dmphutung_con` (
  `id_dm_con` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_dm` INT(10) NOT NULL, -- tham chiếu tới dmsanpham.id_dm
  `ten_dm_con` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_dm_con`),
  KEY `id_dm` (`id_dm`),
  CONSTRAINT `dmphutung_con_ibfk_1` FOREIGN KEY (`id_dm`) REFERENCES `dmsanpham` (`id_dm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chèn dữ liệu vào bảng `dmphutung_con`
INSERT INTO `dmphutung_con` (`id_dm`, `ten_dm_con`) VALUES
(1, 'Thước lái'),
(1, 'Cây láp'),
(2, 'Bugi'),
(2, 'Lọc dầu động cơ'),
(3, 'Dàn nóng'),
(3, 'Dàn lạnh'),
(4, 'Đèn hậu'),
(4, 'Đèn pha'),
(5, 'Nước làm mát động cơ'),
(6, 'Màn hình'),
(6, 'Gương chiếu hậu');

-- --------------------------------------------------------
-- Tạo bảng `blsanpham` (Bình luận sản phẩm)
-- --------------------------------------------------------
CREATE TABLE `blsanpham` (
  `id_bl` int(10) NOT NULL AUTO_INCREMENT,
  `id_sp` int(10) NOT NULL,
  `ten` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dien_thoai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `binh_luan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_gio` datetime NOT NULL,
  PRIMARY KEY (`id_bl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE blsanpham
ADD COLUMN phan_hoi_admin TEXT NULL AFTER binh_luan;

-- Chèn dữ liệu vào bảng `blsanpham`
INSERT INTO `blsanpham` (`id_bl`, `id_sp`, `ten`, `dien_thoai`, `binh_luan`, `ngay_gio`) VALUES
(0, 29, 'Võ Minh Hạnh', '00000', 'fdsfsdgfsg', '2024-08-26 20:55:28');

-- --------------------------------------------------------
-- Tạo bảng `chitiet_donhang` (Chi tiết đơn hàng)
-- --------------------------------------------------------
CREATE TABLE `chitiet_donhang` (
  `id_chitiet` int(11) NOT NULL AUTO_INCREMENT,
  `id_donhang` int(11) DEFAULT NULL,
  `id_sanpham` int(11) DEFAULT NULL,
  `ten_sanpham` varchar(255) DEFAULT NULL,
  `gia` float DEFAULT NULL,
  `so_luong` int(11) DEFAULT NULL,
  `thanh_tien` float DEFAULT NULL,
  PRIMARY KEY (`id_chitiet`),
  KEY `id_donhang` (`id_donhang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tạo bảng `donhang` (Đơn hàng)
-- --------------------------------------------------------
CREATE TABLE `donhang` (
  `id_donhang` int(11) NOT NULL AUTO_INCREMENT,
  `id_khachhang` int(11) DEFAULT NULL,
  `ten_khachhang` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `tong_gia` float NOT NULL,
  `ngay_dat` datetime DEFAULT current_timestamp(),
  `trang_thai` enum('Chờ giao hàng','Đang giao hàng','Đã thanh toán') DEFAULT 'Chờ giao hàng',
  `phuong_thuc_thanh_toan` enum('Tiền mặt','Chuyển khoản ngân hàng','Ví MOMO') DEFAULT 'Tiền mặt',
  PRIMARY KEY (`id_donhang`),
  KEY `id_khachhang` (`id_khachhang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tạo bảng `sanpham` (Sản phẩm)
-- --------------------------------------------------------
CREATE TABLE `sanpham` (
  `id_sp` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_dm` int(11) UNSIGNED NOT NULL,
  `ten_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anh_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `khuyen_mai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `trang_thai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dac_biet` int(1) NOT NULL,
  `chi_tiet_sp` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_luong` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `so_luong_da_ban` int(11) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_sp`),
  KEY `id_dm` (`id_dm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO sanpham (
    id_dm, ten_sp, anh_sp, gia_sp, khuyen_mai, trang_thai, dac_biet,
    chi_tiet_sp, so_luong, so_luong_da_ban
) VALUES
-- 1. Phụ tùng gầm (id_dm = 1)
(1, 'Thước lái cao cấp', 'https://www.testingautos.com/car_care/images/tie-rod.jpg',
 '2500000', 'Không', 'Còn hàng', 1,
 'Thước lái chịu lực cao, làm từ thép hợp kim chất lượng cao, giúp xe vận hành mượt mà. Được thiết kế đặc biệt cho các loại xe từ 4 đến 7 chỗ, sản phẩm có thể chịu được các tải trọng lớn và đảm bảo độ bền lâu dài. Thời gian bảo hành sản phẩm lên đến 12 tháng. Thước lái này là sự lựa chọn lý tưởng cho những ai tìm kiếm một phụ tùng thay thế chất lượng cao, dễ dàng lắp đặt và bảo trì.', 20, 0),
(1, 'Cây láp động lực', 'https://zestech.vn/wp-content/uploads/2022/06/cay-lap-la-gi.jpg',
 '1850000', 'Không', 'Còn hàng', 0,
 'Cây láp động lực được làm từ thép hợp kim cao cấp, giúp truyền động mạnh mẽ và giảm rung lắc khi vào cua, nâng cao trải nghiệm lái xe. Sản phẩm có tính năng bền bỉ, tuổi thọ dài và có khả năng chịu nhiệt cao. Cây láp này thích hợp với nhiều dòng xe, giúp cải thiện độ ổn định của xe, đặc biệt là khi di chuyển ở tốc độ cao. Hỗ trợ lắp ráp dễ dàng, giảm thiểu thời gian sửa chữa.', 30, 0),

-- 2. Phụ tùng động cơ (id_dm = 2)
(2, 'Bugi đánh lửa Iridium', 'https://danchoioto.vn/wp-content/uploads/2021/02/bugi-nickel.jpg.webp',
 '320000', 'Không', 'Còn hàng', 0,
 'Bugi đánh lửa Iridium có khả năng duy trì hiệu suất đánh lửa ổn định trong thời gian dài, giúp động cơ hoạt động mượt mà và tiết kiệm nhiên liệu hơn. Sản phẩm được làm từ vật liệu Iridium, giúp tăng độ bền gấp 2 lần so với các loại bugi thông thường. Nó cũng giúp giảm khí thải và cải thiện khả năng tăng tốc của xe. Bugi này là một sự lựa chọn tuyệt vời để thay thế cho các loại bugi cũ hoặc khi cần nâng cấp hiệu suất động cơ.', 100, 0),
(2, 'Lọc dầu động cơ cao cấp', 'https://cdn.phutungmitsubishi.vn/media/b%C3%A0i%20vi%E1%BA%BFt/thay-loc-nhot-dong-co%20%281%29.jpg',
 '260000', 'Không', 'Còn hàng', 0,
 'Lọc dầu động cơ cao cấp này được làm từ vật liệu giấy sợi tổng hợp có khả năng giữ bẩn cực kỳ hiệu quả. Sản phẩm giúp lọc sạch các tạp chất trong dầu, bảo vệ động cơ tránh khỏi các hư hỏng do cặn bẩn. Với chất liệu bền bỉ và công nghệ sản xuất tiên tiến, lọc dầu này có thể sử dụng được lâu dài, giúp kéo dài tuổi thọ động cơ và giảm chi phí bảo dưỡng xe. Khuyến nghị thay lọc dầu mỗi 8.000 km để đảm bảo hiệu suất tối ưu cho động cơ.', 80, 0),

-- 3. Phụ tùng điện lạnh (id_dm = 3)
(3, 'Dàn nóng điều hoà nhôm nguyên khối', 'https://phutungotohp.vn/wp-content/uploads/2022/07/so-do-he-thong-gian-nong-dieu-hoa-tren-o-to.png',
 '3600000', 'Không', 'Còn hàng', 1,
 'Dàn nóng điều hoà được làm từ nhôm nguyên khối với cấu trúc ống phẳng giúp tản nhiệt nhanh chóng và hiệu quả. Dàn nóng này thích hợp cho các dòng xe sedan và SUV, giúp giữ nhiệt độ ổn định trong khoang xe. Được thiết kế để tối ưu hóa hiệu suất làm lạnh, sản phẩm cũng dễ dàng bảo trì và thay thế. Với chất liệu nhôm bền bỉ, dàn nóng này sẽ giúp hệ thống điều hòa xe của bạn hoạt động mượt mà hơn trong suốt mùa hè oi bức.', 12, 0),
(3, 'Dàn lạnh điều hoà đa lớp', 'https://tuning.vn/media/tintuc/1638982800/dan-lanh-o-to_%284%29.jpg',
 '2950000', 'Không', 'Còn hàng', 0,
 'Dàn lạnh điều hoà này được thiết kế đa lớp giúp tăng cường khả năng làm mát và duy trì nhiệt độ thấp trong xe. Được phủ lớp chống nấm mốc, sản phẩm giúp ngăn ngừa vi khuẩn và mùi hôi khó chịu trong cabin. Dàn lạnh này giúp xe của bạn luôn có không khí trong lành, mát mẻ, và dễ dàng vệ sinh khi cần thiết. Sản phẩm phù hợp với tất cả các dòng xe ô tô và có thể thay thế nhanh chóng, không làm gián đoạn công việc bảo dưỡng của bạn.', 15, 0),

-- 4. Phụ tùng thân vỏ (id_dm = 4)
(4, 'Đèn hậu LED nguyên cụm', 'https://vietnamgarage.vn/wp-content/uploads/2023/10/Den-Hau-Nguyen-Cum-7.png',
 '2100000', 'Không', 'Còn hàng', 1,
 'Đèn hậu LED nguyên cụm với thiết kế đẹp mắt, ánh sáng LED rõ nét và bền lâu. Đèn hậu này đạt chuẩn E-mark, lắp đặt dễ dàng mà không cần cắt hay hàn, rất phù hợp cho các dòng xe sedan và hatchback. Sản phẩm giúp xe của bạn nổi bật và an toàn hơn khi di chuyển vào ban đêm hoặc trong điều kiện thời tiết xấu. Đèn hậu LED này có tuổi thọ cao và tiết kiệm năng lượng, giúp bạn tiết kiệm chi phí bảo dưỡng lâu dài.', 18, 0),
(4, 'Đèn pha bi-LED siêu sáng', 'https://cdn.chungauto.vn/uploads/den-o-to/den-led-o-to.jpg',
 '3500000', 'Không', 'Còn hàng', 1,
 'Đèn pha bi-LED siêu sáng với ánh sáng trắng 6000K giúp tầm nhìn xa và rõ hơn khi lái xe vào ban đêm. Đèn pha này sử dụng công nghệ projector, giúp chiếu sáng mạnh mẽ mà không gây chói mắt cho người lái xe khác. Sản phẩm còn được thiết kế với tản nhiệt nhôm đúc, giúp duy trì hiệu suất chiếu sáng lâu dài mà không bị nóng. Đèn pha bi-LED này là sự lựa chọn lý tưởng cho các dòng xe thể thao và sang trọng.', 10, 0),

-- 5. Dầu nhờn - Phụ gia ô tô (id_dm = 5)
(5, 'Nước làm mát tiêu chuẩn xanh', 'https://focar.vn/Upload/product/green-coolant/avatar-nuoc-lam-mat-tieu-chuan-focar-green-coolant.webp',
 '190000', 'Không', 'Còn hàng', 0,
 'Dung dịch làm mát gốc Ethylene Glycol, giúp làm mát động cơ nhanh chóng, chống gỉ và chống sôi hiệu quả. Sản phẩm được pha sẵn 50/50 và có thể sử dụng cho tất cả các loại xe ô tô, giúp duy trì hiệu suất làm mát và kéo dài tuổi thọ động cơ. Nước làm mát này thích hợp cho mọi điều kiện khí hậu, đặc biệt là trong mùa hè nóng bức, giúp bảo vệ động cơ khỏi quá nhiệt.', 120, 0),

-- 6. Phụ tùng nội thất (id_dm = 6)
(6, 'Màn hình Android 10 inch', 'https://carcam.vn/data/media/2071/files/Tin%20tuc/tin%20hang%20ngay/carcam-tin-tuc-00001.jpg',
 '8500000', 'Không', 'Còn hàng', 1,
 'Màn hình Android 10 inch với màn hình cảm ứng IPS, RAM 4GB và bộ nhớ trong 64GB, hỗ trợ kết nối CarPlay và Android Auto. Thiết bị này giúp cải thiện trải nghiệm giải trí trên xe, hỗ trợ hiển thị bản đồ, xem phim, nghe nhạc và điều khiển các chức năng xe. Với thiết kế sang trọng và dễ sử dụng, màn hình này là một phụ kiện không thể thiếu cho các dòng xe hiện đại.', 25, 0),
(6, 'Gương chiếu hậu chống chói', 'https://lifepro.vn/wp-content/uploads/bang-gia-guong-chieu-hau-o-to-va-cach-thay-the-guong-chieu-hau.jpg',
 '690000', 'Không', 'Còn hàng', 0,
 'Gương chiếu hậu chống chói giúp giảm ánh sáng mạnh từ xe phía sau, đảm bảo tầm nhìn tốt hơn khi lái xe vào ban đêm. Gương này có thiết kế thông minh, có khả năng tự điều chỉnh độ sáng và bảo vệ mắt của người lái. Đây là một phụ kiện không thể thiếu cho các tài xế lái xe vào ban đêm, giúp bảo vệ sức khỏe mắt và tăng cường độ an toàn khi lái xe.', 40, 0);

-- --------------------------------------------------------
-- Tạo bảng `thanhvien` (Thành viên)
-- --------------------------------------------------------
CREATE TABLE `thanhvien` (
  `id_thanhvien` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_khau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vai_tro` enum('chu_shop','nhan_vien') NOT NULL DEFAULT 'nhan_vien',
  PRIMARY KEY (`id_thanhvien`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `thanhvien` (`email`, `mat_khau`, `vai_tro`) VALUES

('admin@shop.com',
 'admin123',
 'chu_shop'),


('staff1@shop.com',
 'nhanvien123',
 'nhan_vien');


-- --------------------------------------------------------
-- Tạo bảng `khachhang` (Khách hàng)
-- --------------------------------------------------------
CREATE TABLE `khachhang` (
  `id_khachhang` int(11) NOT NULL AUTO_INCREMENT,
  `ten_khachhang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_khau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dia_chi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_dang_ky` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_khachhang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tạo bảng `yeu_thich` (Yêu thích)
-- --------------------------------------------------------
CREATE TABLE `yeu_thich` (
  `id_yeu_thich` int(11) NOT NULL AUTO_INCREMENT,
  `id_khachhang` int(11) NOT NULL,
  `id_sanpham` int(11) UNSIGNED NOT NULL,
  `ngay_them` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_yeu_thich`),
  KEY `id_khachhang` (`id_khachhang`),
  KEY `id_sanpham` (`id_sanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tạo bảng `thong_so_ky_thuat` (Thông số kỹ thuật sản phẩm)
-- --------------------------------------------------------
CREATE TABLE `thong_so_ky_thuat` (
  `id_thong_so` int(11) NOT NULL AUTO_INCREMENT,
  `id_sanpham` int(11) UNSIGNED NOT NULL,
  `ten_thong_so` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia_tri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_thong_so`),
  KEY `id_sanpham` (`id_sanpham`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO thong_so_ky_thuat (id_sanpham, ten_thong_so, gia_tri) VALUES
-- 1. Phụ tùng gầm (id_dm = 1)
(1, 'Chiều dài thước lái', '500 mm'),
(1, 'Trọng lượng', '1.2 kg'),
(1, 'Vật liệu', 'Thép hợp kim cao cấp'),
(2, 'Chiều dài cây láp', '850 mm'),
(2, 'Trọng lượng', '1.5 kg'),
(2, 'Vật liệu', 'Thép hợp kim chịu nhiệt cao'),

-- 2. Phụ tùng động cơ (id_dm = 2)
(3, 'Điện áp hoạt động', '12V'),
(3, 'Dòng điện tiêu thụ', '0.2A'),
(3, 'Bảo hành', '12 tháng'),
(4, 'Dòng chảy dầu', '500 l/h'),
(4, 'Bảo hành', '6 tháng'),

-- 3. Phụ tùng điện lạnh (id_dm = 3)
(5, 'Kích thước dàn nóng', '400 x 300 x 120 mm'),
(5, 'Vật liệu dàn nóng', 'Nhôm nguyên khối'),
(5, 'Công suất làm mát', '3000 BTU'),
(6, 'Kích thước dàn lạnh', '500 x 400 x 120 mm'),
(6, 'Vật liệu dàn lạnh', 'Nhôm phủ chống nấm mốc'),
(6, 'Công suất làm mát', '2800 BTU'),

-- 4. Phụ tùng thân vỏ (id_dm = 4)
(7, 'Độ sáng đèn hậu', '500 lumens'),
(7, 'Màu ánh sáng', 'Đỏ'),
(7, 'Tuổi thọ LED', '50,000 giờ'),
(8, 'Độ sáng đèn pha', '3000 lumens'),
(8, 'Màu ánh sáng', 'Trắng 6000K'),
(8, 'Tuổi thọ LED', '40,000 giờ'),

-- 5. Dầu nhờn - Phụ gia ô tô (id_dm = 5)
(9, 'Dung tích', '1 lít'),
(9, 'Công dụng', 'Chống gỉ, chống sôi, bảo vệ động cơ'),
(9, 'Nhiệt độ làm việc', '-40°C đến 120°C'),

-- 6. Phụ tùng nội thất (id_dm = 6)
(10, 'Màn hình cảm ứng', '10 inch IPS'),
(10, 'Kết nối', 'CarPlay, Android Auto'),
(10, 'Bộ nhớ trong', '64GB'),
(11, 'Gương chiếu hậu', 'Điện tử, chống chói'),
(11, 'Kích thước gương', '10 x 5 cm'),
(11, 'Chất liệu gương', 'Kính chống chói xanh dương');

-- --------------------------------------------------------
-- Tạo bảng `images` lưu link ảnh phụ tùng
-- --------------------------------------------------------
CREATE TABLE `images` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `part_name` varchar(255) NOT NULL,
  `image_link` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_part_name` (`part_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chèn dữ liệu vào bảng `images` (link ảnh phụ tùng)
INSERT INTO `images` (`part_name`, `image_link`) VALUES
('Thước lái', 'https://www.testingautos.com/car_care/images/tie-rod.jpg'),
('Thước lái', 'https://bacnam.vn/wp-content/uploads/2024/03/Thuoc-lai-O-to-Hyundai-2-1.jpg'),
('Cây láp', 'https://zestech.vn/wp-content/uploads/2022/06/cay-lap-la-gi.jpg'),
('Cây láp', 'https://www3.wuling.id/wp-content/uploads/2024/06/Cover.jpg'),
('Cây láp', 'https://i0.wp.com/www.theengineeringchoice.com/wp-content/uploads/2024/06/What-is-a-Drive-Shaft.webp'),
('Bugi', 'https://danchoioto.vn/wp-content/uploads/2021/02/bugi-nickel.jpg.webp'),
('Bugi', 'https://images02.military.com/sites/default/files/styles/full/public/media/offduty/auto-center/2013/08/sparkplugs.jpg'),
('Bugi', 'https://www.fitch-autos.co.uk/wp-content/uploads/sites/5/2025/03/Spark-Plugs-Engine-Diagram.png'),
('Lọc dầu động cơ', 'https://cdn.phutungmitsubishi.vn/media/b%C3%A0i%20vi%E1%BA%BFt/thay-loc-nhot-dong-co%20%281%29.jpg'),
('Lọc dầu động cơ', 'https://s19528.pcdn.co/wp-content/uploads/2019/01/Oil-Filters.jpg'),
('Dàn nóng', 'https://phutungotohp.vn/wp-content/uploads/2022/07/so-do-he-thong-gian-nong-dieu-hoa-tren-o-to.png'),
('Dàn nóng', 'https://i.ytimg.com/vi/rVNLhPxvTXM/maxresdefault.jpg'),
('Dàn nóng', 'https://www.lincolncustomauto.com/Files/Images/blog/acsystem.jpg'),
('Dàn lạnh', 'https://tuning.vn/media/tintuc/1638982800/dan-lanh-o-to_%284%29.jpg'),
('Dàn lạnh', 'https://carlightvision.com/wp-content/uploads/headlight-of-a-black-car.jpeg.webp'),
('Dàn lạnh', 'https://parkers-images.bauersecure.com/wp-images/17166/930x620/what_are_led_headlights_50.jpg'),
('Đèn hậu', 'https://vietnamgarage.vn/wp-content/uploads/2023/10/Den-Hau-Nguyen-Cum-7.png'),
('Đèn hậu', 'https://www.howacarworks.com/illustration/2075/overhauling-a-light-cluster--2.png'),
('Đèn hậu', 'https://undergroundlighting.com/cdn/shop/articles/Understanding_Red_Brake_Lights_on_Your_Car_0189cfd1-9ee0-46e7-ab2f-706f9fc399cf.jpg?v=1749616242'),
('Đèn pha', 'https://cdn.chungauto.vn/uploads/den-o-to/den-led-o-to.jpg'),
('Đèn pha', 'https://carlightvision.com/wp-content/uploads/headlight-of-a-black-car.jpeg.webp'),
('Đèn pha', 'https://images.app.ridemotive.com/g2b8cn7ol2lrfxp1ucbo0kzt8i0k'),
('Nước làm mát động cơ', 'https://focar.vn/Upload/product/green-coolant/avatar-nuoc-lam-mat-tieu-chuan-focar-green-coolant.webp'),
('Nước làm mát động cơ', 'https://bdc2020.o0bc.com/wp-content/uploads/2019/07/RadiatorReport-scaled.jpg'),
('Nước làm mát động cơ', 'https://natrad.com.au/wp-content/uploads/2017/08/radiator-coolant-hero-1030x588.jpg'),
('Màn hình', 'https://carcam.vn/data/media/2071/files/Tin%20tuc/tin%20hang%20ngay/carcam-tin-tuc-00001.jpg'),
('Màn hình', 'https://media.wired.com/photos/62a22acc8006a383782cdb62/3%3A2/w_2560%2Cc_limit/Apple-iOS16-CarPlay-Business-220606.jpg'),
('Màn hình', 'https://www.cnet.com/a/img/resize/a5af29b167a75a3fec4a9d019e5a7b01dbe70086/hub/2018/06/11/1c80ec49-843a-428b-af70-0dfc846cff3f/infotainment-lead.jpg?auto=webp&fit=crop&height=675&width=1200'),
('Gương chiếu hậu', 'https://lifepro.vn/wp-content/uploads/bang-gia-guong-chieu-hau-o-to-va-cach-thay-the-guong-chieu-hau.jpg'),
('Gương chiếu hậu', 'https://images.unsplash.com/photo-1721631576246-023fd2745ee1?fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDM0fHx8ZW58MHx8fHx8&ixlib=rb-4.0.3&q=60&w=3000'),
('Gương chiếu hậu', 'https://m.media-amazon.com/images/I/61T6Bm%2BIjUL._AC_UF894%2C1000_QL80_.jpg');


-- --------------------------------------------------------
-- Các ràng buộc cho các bảng đã đổ
-- --------------------------------------------------------

-- Các ràng buộc cho bảng `chitiet_donhang`
ALTER TABLE `chitiet_donhang`
  ADD CONSTRAINT `chitiet_donhang_ibfk_1` FOREIGN KEY (`id_donhang`) REFERENCES `donhang` (`id_donhang`);

-- Các ràng buộc cho bảng `donhang`
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`id_khachhang`) REFERENCES `khachhang` (`id_khachhang`);

-- Các ràng buộc cho bảng `yeu_thich`
ALTER TABLE `yeu_thich`
  ADD CONSTRAINT `yeu_thich_ibfk_1` FOREIGN KEY (`id_khachhang`) REFERENCES `khachhang` (`id_khachhang`),
  ADD CONSTRAINT `yeu_thich_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sp`);

-- Các ràng buộc cho bảng `thong_so_ky_thuat`
ALTER TABLE `thong_so_ky_thuat`
  ADD CONSTRAINT `thong_so_ky_thuat_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `sanpham` (`id_sp`);

ALTER TABLE blsanpham ADD COLUMN phan_hoi_admin TEXT NULL AFTER binh_luan;
    
COMMIT;
