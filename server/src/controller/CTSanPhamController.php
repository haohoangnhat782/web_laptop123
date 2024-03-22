<?php

require_once __DIR__ . '/../model/ConnectDB.php';
include __DIR__ . '/../model/ChiTietSanPham/ChiTietSanPham.php';
include __DIR__ . '/../model/ChiTietSanPham/ChiTietSanPhamRepo.php';

class CTSanPhamController {
    private $ctspRepo;

    public function __construct() {
        $this->ctspRepo = new ChiTietSanPhamRepo();
    }

    public function getData() {
        $productDetails = $this->ctspRepo->getData();
        $result = [];

        foreach ($productDetails as $productDetail) {
            if ($productDetail['trang_thai'] == 0) {
                $result[] = $productDetail;
            }
        }
        
        echo json_encode($result);
    }

    public function getAllProductDetails() {
        echo json_encode($this->ctspRepo->getData());
    }

    public function getProductDetail($productDetailId) {
        echo json_encode($this->ctspRepo->getProductDetail($productDetailId));
    }

    public function getProductDetailsLength() : int {
        return $this->ctspRepo->getProductDetailsLength();
    }

    public function addProductDetail($productDetail) {
        if ($this->ctspRepo->addProductDetail($productDetail)) {
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    public function updateProductDetail($productDetail) {
        if ($this->ctspRepo->updateProductDetail($productDetail)) {
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    public function deleteProductDetail($productDetailId) {
        if ($this->ctspRepo->deleteProductDetail($productDetailId)) {
            echo 'success';
        } else {
            echo 'fail';
        }
    }
}

$ctspCtl = new CTSanPhamController();
$action = $_POST['action'];

switch ($action) {
    case 'get-data':
        $ctspCtl->getData();
        break;
    case 'get-all':
        $ctspCtl->getAllProductDetails();
        break;
    case 'get':
        $productDetailId = $_POST['productDetailId'];
        $ctspCtl->getProductDetail($productDetailId);
        break;
    case 'add':
        $length = $ctspCtl->getProductDetailsLength();
        if ($length >= 0) {
            $length += 1;
            $productDetailId = 'CTSP'.sprintf('%04d', $length);
            $obj = json_decode(json_encode($_POST['productDetail']));
            $productId = $_POST['productId'];
            $img = "server/src/assets/images/$productId.png";
            $price = 0;
            
            $productDetail = new ChiTietSanPham(
                $productDetailId,
                $productId,
                $obj->{'cpuId'},
                $obj->{'colorId'},
                $obj->{'gpuId'},
                $obj->{'plugId'},
                $obj->{'ram'},
                $obj->{'rom'},
                $img,
                $price,
                0
            );
            $ctspCtl->addProductDetail($productDetail);
        }
        break;
    case 'update':
        $productDetailId = $_POST['productDetailId'];
        $productId = $_POST['productId'];
        $cpuId = $_POST['cpuId'];
        $colorId = $_POST['colorId'];
        $gpuId = $_POST['gpuId'];
        $plugId = $_POST['plugId'];
        $ram = $_POST['ram'];
        $rom = $_POST['rom'];
        $image = $_POST['image'];
        $price = $_POST['price'];
        
        $productDetail = new ChiTietSanPham($productDetailId, $productId, $cpuId, $colorId, $gpuId, $plugId, $ram, $rom, $image, $price, 0);
        $ctspCtl->updateProductDetail($productDetail);
        break;
    case 'delete':
        $productDetailId = $_POST['productDetailId'];
        $ctspCtl->deleteProductDetail($productDetailId);
        break;
    default:
        break;
}