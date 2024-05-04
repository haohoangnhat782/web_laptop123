<main>
	<div class="container-xl">
		<div class="table-responsive">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<h2>Quản Lý <b id="ad-NhomQuyen">Nhập Hàng</b></h2>
						</div>
						<?php if (true) {  ?>
                        <div class="col-sm-6">
                            <a href="#addimportModal" class="btn btn-success btn-pay-cartimport add" data-toggle="modal">
								<i class="material-icons">&#xE147;</i>
								<span>Thanh Toán</span>
							</a>
						</div>
						<?php } else echo "Nothing"  ?>
					</div>
				</div>
			
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="w-auto">Mã sản phẩm</th>
							<th class="w-auto">Mã Chi Tiết Sản Phẩm</th>
							<th class="w-auto">Tên Sản Phẩm</th>
                            <th class="w-auto">Hình Ảnh</th>
							<th class="w-auto">Nhà Cung Cấp</th>
							<th class="w-auto">Số Lượng</th>
							<th class="w-auto">Giá</th>
							<th class="w-auto">Tổng Tiền</th>
                            <th class="w-auto">Action(Xóa)</th>
						</tr>
					</thead>
					<tbody id="show-listNhomQuyen">
					<?php
if (isset($_SESSION['cartimport']) && is_array($_SESSION['cartimport'])) {
    $cart = $_SESSION['cartimport'];
    $tongtien = 0;
    foreach ($cart as $cart1) {
        foreach ($cart1 as $ma => $each) {
			if (array_key_exists("gia_nhap", $each)) {
            $gia_nhap = intval($each['gia_nhap']);
		} else {
			continue;
		}
            $quantity = intval($each['quantity']);

            $thanhtien = ($gia_nhap * $quantity);
            $tongtien += $thanhtien;
?>
						<input type="hidden" class="inp-ma-ncc" value="<?php echo $each['ma_ncc'] ?>">
            <tr>
                <td><?php echo $each['ma_sp'] ?></td>
				<td><?php echo $each['ma_ctsp'] ?></td>
                <td><?php echo $each['ten_sp'] ?></td>
                <td><img src="<?php echo $each['hinh_anh'] ?>" alt="Hình ảnh sản phẩm"></td>
                <td><?php echo $each['ten_ncc'] ?></td>
                <td><input class="change-quanty-cartimport" data-ma="<?php echo $each['ma_sp'] ?>" data-mactsp="<?php echo $each['ma_ctsp'] ?>" style="width: 50px" type="number" min=1 value="<?php echo $quantity ?>"></td>
                <td><?php echo number_format($gia_nhap, 0, ',', '.') . 'VND' ?></td>
                <td><?php echo number_format($thanhtien, 0, ',', '.') . 'VND' ?></td>
                <td>
                    <?php if (true) { ?>
                        <button class="btn-delete-productcart" value="<?php echo $ma . '.' . $each['ma_ncc'] ?>">Xóa</button>
                    <?php } else echo 'Nothing' ?>
                </td>
            </tr>
<?php
        }
    }
} else {
    echo "<tr><td colspan='8' style='color: red; font-weight: bold;'>Không có dữ liệu giỏ hàng.</td></tr>";
}
?>

					</tbody>
				</table>
				<div class="clearfix">
					<input type="hidden" name="totalPriceImport" value="<?php echo isset($tongtien) ? $tongtien : 0 ?>">
					<p style="margin-top: 20px; font-size: 1.4rem;">Tổng thanh toán: <?php echo isset($tongtien) ? number_format($tongtien, 0, ',', '.') . 'VND' : '0 VND' ?></p>

					<div class="hint-text">
    					Showing <b id="cur">5</b> out of <b id="total">25</b> entries
					</div>

					<div id="pagination">
                    </div>
					<input type="hidden" name="currentpage" id="currentpage" value="1">
				</div>
			</div>
		</div>
	</div>
</main>

<script src="/client/pages/PhieuNhap.js"></script>
