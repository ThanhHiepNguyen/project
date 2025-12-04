# Phân tích chức năng còn thiếu

## ✅ CÁC CHỨC NĂNG ĐÃ CÓ

### Trang Chủ:
- ✅ Hiển thị sản phẩm đặc biệt (dac_biet = 1)
- ✅ Hiển thị sản phẩm mới nhất
- ✅ Hiển thị số lượng sản phẩm còn hàng (so_luong)
- ❌ **THIẾU:** Sản phẩm thịnh hành (bán chạy nhất)
- ❌ **THIẾU:** Gợi ý sản phẩm cùng danh mục

### Tìm Kiếm và Lọc:
- ✅ Tìm kiếm sản phẩm theo tên
- ❌ **THIẾU:** Lọc sản phẩm theo giá (từ-tháng đến)
- ❌ **THIẾU:** Lọc sản phẩm theo trạng thái (còn hàng, hết hàng)
- ❌ **THIẾU:** Sắp xếp sản phẩm (giá tăng/giảm, mới nhất, bán chạy)

### Giỏ Hàng:
- ✅ Thêm sản phẩm vào giỏ hàng
- ✅ Xem giỏ hàng và tổng giá trị
- ✅ Xóa sản phẩm khỏi giỏ hàng
- ✅ Cập nhật số lượng

### Trang Chi Tiết Sản Phẩm:
- ✅ Hiển thị mô tả chi tiết sản phẩm
- ✅ Hiển thị giá, khuyến mãi
- ✅ Hiển thị số lượng còn hàng
- ❌ **THIẾU:** Thông số kỹ thuật sản phẩm (chưa có bảng thông số)
- ❌ **THIẾU:** Thêm sản phẩm vào yêu thích (wishlist)

### Quản Lý Đơn Hàng:
- ✅ Tra cứu đơn hàng bằng số điện thoại
- ✅ Xem thông tin đơn hàng
- ❌ **THIẾU:** Theo dõi trạng thái đơn hàng theo tài khoản (chỉ tra cứu bằng SĐT)
- ❌ **THIẾU:** Xem lịch sử đơn hàng theo tài khoản

### Admin:
- ✅ Quản lý sản phẩm (thêm, sửa, xóa)
- ✅ Quản lý đơn hàng (xem, cập nhật trạng thái)
- ✅ Quản lý danh mục
- ✅ Quản lý thành viên admin (thêm, sửa, xóa)
- ❌ **THIẾU:** Phân quyền (chủ shop vs nhân viên)
- ❌ **THIẾU:** Quản lý người dùng (khách hàng)
- ❌ **THIẾU:** Thống kê và báo cáo

---

## ❌ CÁC CHỨC NĂNG CÒN THIẾU

### 🔴 QUAN TRỌNG NHẤT (Ưu tiên cao)

#### 1. **Đăng Ký/Đăng Nhập Khách Hàng**
**Hiện tại:** 
- Chỉ có đăng nhập admin (quantri/index.php)
- Khách hàng mua hàng không cần đăng nhập, chỉ nhập thông tin khi đặt hàng

**Cần thêm:**
- ❌ Trang đăng ký khách hàng
- ❌ Trang đăng nhập khách hàng
- ❌ Bảng `khachhang` trong database (hiện chỉ có `thanhvien` cho admin)
- ❌ Session quản lý đăng nhập khách hàng
- ❌ Đăng nhập qua Google OAuth
- ❌ Đăng nhập qua Facebook OAuth
- ❌ Quên mật khẩu
- ❌ Xác thực email

**Tác động:** Không có tài khoản khách hàng → không thể lưu lịch sử, yêu thích, địa chỉ

---

#### 2. **Chỉnh Sửa Hồ Sơ Cá Nhân**
**Hiện tại:** Không có

**Cần thêm:**
- ❌ Trang quản lý tài khoản
- ❌ Sửa thông tin cá nhân (tên, email, SĐT)
- ❌ Đổi mật khẩu
- ❌ Quản lý địa chỉ giao hàng (nhiều địa chỉ)
- ❌ Upload avatar
- ❌ Xem lịch sử đơn hàng của chính mình

**Tác động:** Khách hàng không thể quản lý thông tin cá nhân

---

#### 3. **Yêu Thích/Wishlist**
**Hiện tại:** Không có

**Cần thêm:**
- ❌ Bảng `yeu_thich` hoặc `wishlist` trong database
- ❌ Nút "Thêm vào yêu thích" ở trang chi tiết sản phẩm
- ❌ Trang danh sách yêu thích
- ❌ Xóa khỏi yêu thích
- ❌ Hiển thị sản phẩm yêu thích khi tìm kiếm (nếu đã đăng nhập)

**Tác động:** Mất cơ hội bán hàng, khách không thể lưu sản phẩm để mua sau

---

#### 4. **Lọc và Sắp Xếp Sản Phẩm**
**Hiện tại:** 
- Chỉ có tìm kiếm theo tên
- Không có lọc hoặc sắp xếp

**Cần thêm:**
- ❌ Lọc theo giá (từ X đến Y)
- ❌ Lọc theo danh mục (đã có nhưng chưa có filter UI)
- ❌ Lọc theo trạng thái (còn hàng, hết hàng, sắp hết)
- ❌ Sắp xếp: Giá tăng dần, Giá giảm dần, Mới nhất, Bán chạy nhất
- ❌ UI filter sidebar hoặc dropdown

**Tác động:** Khách hàng khó tìm sản phẩm phù hợp

---

#### 5. **Gợi Ý Sản Phẩm Cùng Danh Mục**
**Hiện tại:** 
- Trang chủ chỉ có "Sản phẩm đặc biệt" và "Sản phẩm mới"
- Trang chi tiết sản phẩm không có sản phẩm liên quan

**Cần thêm:**
- ❌ Hiển thị sản phẩm cùng danh mục ở trang chi tiết
- ❌ Hiển thị sản phẩm tương tự
- ❌ "Sản phẩm đã xem" (recently viewed)
- ❌ "Có thể bạn cũng thích" (recommendations)

**Tác động:** Mất cơ hội cross-sell, giảm doanh số

---

#### 6. **Sản Phẩm Thịnh Hành**
**Hiện tại:** 
- Có "Sản phẩm đặc biệt" (dac_biet = 1)
- Không có sản phẩm thịnh hành/bán chạy

**Cần thêm:**
- ❌ Tính toán sản phẩm bán chạy dựa trên số lượng đã bán
- ❌ Hiển thị "Sản phẩm thịnh hành" trên trang chủ
- ❌ Có thể thêm cột `so_luong_da_ban` vào bảng `sanpham`

**Tác động:** Không highlight được sản phẩm bán chạy

---

#### 7. **Thông Số Kỹ Thuật Sản Phẩm**
**Hiện tại:** 
- Chỉ có mô tả chi tiết (chi_tiet_sp)
- Không có bảng thông số kỹ thuật

**Cần thêm:**
- ❌ Bảng thông số kỹ thuật (chất liệu, kích thước, trọng lượng, v.v.)
- ❌ Có thể thêm bảng `thong_so_ky_thuat` hoặc JSON field
- ❌ Hiển thị dạng bảng đẹp ở trang chi tiết

**Tác động:** Thiếu thông tin quan trọng cho khách hàng

---

#### 8. **Quản Lý Đơn Hàng Theo Tài Khoản**
**Hiện tại:** 
- Chỉ tra cứu bằng số điện thoại
- Không liên kết với tài khoản

**Cần thêm:**
- ❌ Liên kết đơn hàng với tài khoản khách hàng (id_khachhang trong bảng donhang)
- ❌ Trang "Đơn hàng của tôi" khi đã đăng nhập
- ❌ Theo dõi trạng thái đơn hàng real-time
- ❌ Lịch sử đơn hàng đầy đủ

**Tác động:** Trải nghiệm kém, khách phải nhớ số điện thoại

---

### 🟡 QUAN TRỌNG VỪA (Ưu tiên trung bình)

#### 9. **Phân Quyền Admin**
**Hiện tại:** 
- Tất cả admin có quyền như nhau
- Không có phân biệt chủ shop vs nhân viên

**Cần thêm:**
- ❌ Thêm cột `vai_tro` vào bảng `thanhvien` (chủ_shop, nhan_vien)
- ❌ Kiểm tra quyền trước khi truy cập các chức năng
- ❌ Chủ shop: Quản lý tất cả (bao gồm tài khoản nhân viên)
- ❌ Nhân viên: Chỉ quản lý sản phẩm, đơn hàng, người dùng (KHÔNG quản lý tài khoản nhân viên)
- ❌ Middleware kiểm tra quyền

**Tác động:** Bảo mật kém, khó quản lý nhân viên

---

#### 10. **Quản Lý Người Dùng (Admin)**
**Hiện tại:** 
- Admin chỉ quản lý `thanhvien` (admin)
- Không quản lý khách hàng

**Cần thêm:**
- ❌ Trang danh sách khách hàng
- ❌ Xem thông tin chi tiết khách hàng
- ❌ Xem lịch sử mua hàng của từng khách
- ❌ Phân loại khách hàng (VIP, thường)
- ❌ Khóa/mở khóa tài khoản

**Tác động:** Không có dữ liệu để chăm sóc khách hàng

---

#### 11. **Thống Kê và Báo Cáo**
**Hiện tại:** Không có

**Cần thêm:**
- ❌ Dashboard với các chỉ số:
  - Tổng số đơn hàng
  - Doanh thu (theo ngày, tháng, năm)
  - Số lượng sản phẩm đã bán
  - Top sản phẩm bán chạy
  - Số lượng khách hàng mới
  - Đơn hàng theo trạng thái
- ❌ Biểu đồ (chart.js hoặc tương tự)
- ❌ Xuất báo cáo PDF/Excel
- ❌ Báo cáo theo thời gian

**Tác động:** Không có dữ liệu để đưa ra quyết định kinh doanh

---

#### 12. **Đăng Nhập Google/Facebook**
**Hiện tại:** Không có

**Cần thêm:**
- ❌ Tích hợp Google OAuth API
- ❌ Tích hợp Facebook Login API
- ❌ Lưu thông tin từ Google/Facebook
- ❌ Xử lý callback từ OAuth providers

**Tác động:** Giảm trải nghiệm đăng ký, khách phải nhập nhiều thông tin

---

### 🟢 NÂNG CAO (Ưu tiên thấp)

#### 13. **So Sánh Sản Phẩm**
- ❌ Chọn nhiều sản phẩm để so sánh
- ❌ Bảng so sánh chi tiết

#### 14. **Đánh Giá Sản Phẩm** (đã loại trừ theo yêu cầu trước)
- ⚠️ Có form bình luận nhưng chưa có đánh giá sao thực tế

#### 15. **Mã Giảm Giá** (đã loại trừ)
- ⚠️ Đã loại trừ

#### 16. **Thanh Toán Online** (đã loại trừ)
- ⚠️ Đã loại trừ

---

## 📊 TỔNG KẾT

### Số lượng chức năng thiếu:
- **Quan trọng nhất:** 8 chức năng
- **Quan trọng vừa:** 4 chức năng
- **Nâng cao:** 3 chức năng

### Top 5 chức năng nên làm trước:
1. ✅ **Đăng ký/Đăng nhập khách hàng** - Nền tảng cho các tính năng khác
2. ✅ **Yêu thích/Wishlist** - Tăng tỷ lệ chuyển đổi
3. ✅ **Chỉnh sửa hồ sơ cá nhân** - Gắn với đăng nhập
4. ✅ **Lọc và sắp xếp sản phẩm** - Cải thiện trải nghiệm tìm kiếm
5. ✅ **Gợi ý sản phẩm cùng danh mục** - Tăng doanh số

---

## 💡 GỢI Ý THỰC HIỆN

### Bước 1: Database
- Tạo bảng `khachhang` (id, ten, email, mat_khau, so_dien_thoai, dia_chi, ngay_dang_ky)
- Tạo bảng `yeu_thich` (id, id_khachhang, id_sanpham, ngay_them)
- Thêm cột `id_khachhang` vào bảng `donhang`
- Thêm cột `vai_tro` vào bảng `thanhvien`
- Thêm cột `so_luong_da_ban` vào bảng `sanpham`

### Bước 2: Authentication
- Tạo trang đăng ký/đăng nhập khách hàng
- Hash mật khẩu (password_hash)
- Session management

### Bước 3: Features
- Wishlist
- Profile management
- Filter & Sort
- Recommendations

### Bước 4: Admin
- Phân quyền
- Quản lý người dùng
- Thống kê

