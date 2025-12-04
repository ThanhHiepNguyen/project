-- File SQL để cập nhật danh mục sản phẩm từ trang sức sang phụ tùng xe
-- Chạy file này trong phpMyAdmin để cập nhật danh mục

-- Xóa dữ liệu cũ (nếu cần)
-- TRUNCATE TABLE dmsanpham;

-- Cập nhật danh mục sản phẩm cho phụ tùng xe
UPDATE dmsanpham SET ten_dm = 'Phụ tùng động cơ' WHERE id_dm = 1;
UPDATE dmsanpham SET ten_dm = 'Phụ tùng khung gầm' WHERE id_dm = 2;
UPDATE dmsanpham SET ten_dm = 'Phụ tùng điện' WHERE id_dm = 3;
UPDATE dmsanpham SET ten_dm = 'Phụ tùng hệ thống phanh' WHERE id_dm = 4;
UPDATE dmsanpham SET ten_dm = 'Phụ tùng hệ thống làm mát' WHERE id_dm = 5;
UPDATE dmsanpham SET ten_dm = 'Phụ tùng hệ thống lái' WHERE id_dm = 6;
UPDATE dmsanpham SET ten_dm = 'Dầu nhớt & Phụ gia' WHERE id_dm = 7;
UPDATE dmsanpham SET ten_dm = 'Phụ kiện xe' WHERE id_dm = 8;

-- Hoặc nếu muốn thêm mới danh mục (xóa cũ và thêm mới):
-- DELETE FROM dmsanpham;
-- INSERT INTO dmsanpham (id_dm, ten_dm) VALUES
-- (1, 'Phụ tùng động cơ'),
-- (2, 'Phụ tùng khung gầm'),
-- (3, 'Phụ tùng điện'),
-- (4, 'Phụ tùng hệ thống phanh'),
-- (5, 'Phụ tùng hệ thống làm mát'),
-- (6, 'Phụ tùng hệ thống lái'),
-- (7, 'Dầu nhớt & Phụ gia'),
-- (8, 'Phụ kiện xe');

-- Lưu ý: Sau khi chạy file này, bạn cần cập nhật lại dữ liệu sản phẩm trong bảng sanpham
-- để phù hợp với danh mục mới và thông tin phụ tùng xe

