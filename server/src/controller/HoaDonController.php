<?php
include("../model/ConnectDB.php");
include("../model/HoaDon/HoaDon.php");
include("../model/HoaDon/HoaDonRepo.php");

class HoaDonController {
    private $hoadonRepo;

    public function __construct(){
        $this->hoadonRepo = new HoaDonRepo();
    }

    public function getAllHoaDon() {
        echo json_encode($this->hoadonRepo->getAllHoaDon());
    }

    public function getHoaDon($id) {
        echo json_encode($this->hoadonRepo->getHoaDon($id));
    }

    public function getKhachHang($id) {
       echo json_encode($this->hoadonRepo->getThongTinKhachHang($id));
    }

    public function getHoaDonByKhachHang($ma_kh, $tinh_trang, $search) {
        echo json_encode($this->hoadonRepo->getHoaDonByKhachHang($ma_kh, $tinh_trang, $search));
    }
}

$hoadonctl = new HoaDonController();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

switch ($action) {
    case 'load':
        $hoadonctl->getAllHoaDon();
        break;
    case 'get':
        $id = $_POST['id'];
        $hoadonctl->getHoaDon($id);
        break;
    case 'get-khach-hang':
        $id = $_POST['id'];
        $hoadonctl->getKhachHang($id);
        break;
    case 'get-customer-order':
        $ma_kh = $_POST['ma_kh'];
        $tinh_trang = $_POST['tinh_trang'];
        $search = $_POST['search'];
        $hoadonctl->getHoaDonByKhachHang($ma_kh, $tinh_trang, $search);
        break;
    default:
        break;
}