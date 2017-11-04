<?php
error_reporting(E_ALL);
if (!defined('SAFELOAD')) {
    exit('ACCESS FORBIDDEN!');
}

class Model {

    var $server;
    var $port;
    var $username;
    var $password;
    var $database;
    var $conn;

    function __construct() {
        $this->server = Config::$SERVER;
        $this->username = Config::$USER;
        $this->password = Config::$PASS;
        $this->database = Config::$DB;
    }
//    DATA
    function connect(){
        $this->conn = mysqli_connect($this->server, $this->username, $this->password, $this->database);
        if (!$this->conn) {
            echo json_encode(array('code'=>500,'message'=>'DB connection failed.'));
            die();
        }
    }

    function close(){
        mysqli_close($this->conn);
    }

    function getTest($data) {
        return base64_decode($data);
    }

    function login($user, $pass) {
        $sql = "SELECT id, salt, password FROM usr WHERE username = '$user' AND usrcred = 2 LIMIT 1";
        $q = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_array($q);
        mysqli_free_result($q);
        $id = $data['id'];
        $salt = $data['salt'];
        $check = hash('sha256', $pass . $salt);
        for($round = 0; $round < 65536; $round++) {
            $check = hash('sha256', $check . $salt);
        }
        if ($check === $data['password']) {
            return $id;
        } else {
            return false;
        }
    }

    function checkUserExist($user) {
        $sql = "SELECT username FROM usr WHERE username = '$user'";
        $q = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_object($q);

        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function forgotPass($user, $email) {
        $sql = "SELECT username, email FROM usr WHERE username = '$user' AND email = '$email'";
        $q = mysqli_query($this->conn, $sql) or die(false);
        $data = mysqli_fetch_object($q);
        $status = false;
        if (count($data) > 0) {
            $status = true;
        } else {
            $status = false;
        }

        return $status;
    }

    function register($data) {
        $raws = explode(";;", base64_decode($data));
        if (count($raws) != 9) {
            return false;
        }
        $usrcred = 2;
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $raws[1] . $salt);
        for($round = 0; $round < 65536; $round++) {
            $password = hash('sha256', $password . $salt);
        }
        $sql = "INSERT INTO usr (username, password, salt, email, usrcred) VALUES ('$raws[0]', '$password', '$salt', '$raws[2]', $usrcred)";
        $sql2 = "INSERT INTO usr_detail (nama, gender, alamat, kota_kab, kecamatan, telepon) VALUES ('$raws[3]', '$raws[4]', '$raws[5]', '$raws[6]', '$raws[7]', '$raws[8]')";
        $q = mysqli_query($this->conn, $sql) or die('false');
        $q2 = mysqli_query($this->conn, $sql2) or die('false');

        $status = false;
        if ($q && $q2) {
            $status = true;
        }

        return $status;
    }

    function getEmailAdmin() {
        $sql = "SELECT email FROM usr WHERE usrcred = 1";
        $q = mysqli_query($this->conn, $sql);
        $data = mysqli_fetch_object($q);

        return $data;
    }

    function getUsrDetail($id) {
        $sql = "SELECT nama, gender, alamat, kota_kab, kecamatan, telepon, b.email FROM usr_detail a JOIN usr b ON a.id_user = b.id WHERE id_user = $id";
        $q = mysqli_query($this->conn, $sql) or die(false);
        $data = mysqli_fetch_all($q,MYSQLI_ASSOC);
        mysqli_free_result($q);

        return $data;
    }

    function getOrder($id, $mobil, $status) {
        $param1 = '';
        $param2 = '';
        if ($mobil) {
            $param1 = "AND id_mbl_usr = '$mobil'";
        }
        if ($status) {
            $param2 = "AND status = '$status'";
        }
        $sql = "SELECT id_order,
                        id_usr_ord_fk as idUser,
                        d.nama as pemilik,
                        a.id_mbl_usr as idMobil,
                        e.nama_brand as brand,
                        e.produk_mobil as mobil,
                        tanggal,
                        jam,
                        lokasi,
                        b.harga as harga,
                        invoice,
                        status,
                        paket as idPaket,
                        b.nama_paket as paket,
                        b.keterangan as ktrg_paket,
                        c.tipe_pembayaran,
                        c.keterangan_pembayaran
            FROM order_cuci a
            JOIN paket_cuci b ON a.paket = b.id_paket
            JOIN jenis_pembayaran c ON a.pembayaran = c.id_pembayaran
            JOIN usr_detail d ON a.id_usr_ord_fk = d.id_user
            JOIN usr_mobil e ON e.id_kendaraan = a.id_mbl_usr
            WHERE id_usr_ord_fk = $id $param1 $param2 ORDER BY id_order DESC";
        $q = mysqli_query($this->conn, $sql) or die(false);
        $data = mysqli_fetch_all($q,MYSQLI_ASSOC);
        mysqli_free_result($q);

        return $data;
    }

    function cancelOrder($id) {
        $sql = "UPDATE order_cuci SET status = 'Cancelled' WHERE id_order = $id";
        $q = mysqli_query($this->conn, $sql) or die(false);
        // mysqli_free_result($q);

        return $q;
    }

    function getPaket() {
        $sql = "SELECT id_paket, nama_paket, harga, keterangan FROM paket_cuci";
        $q = mysqli_query($this->conn, $sql) or die(false);
        $data = mysqli_fetch_all($q,MYSQLI_ASSOC);
        mysqli_free_result($q);

        return $data;
    }

    function getBayar() {
        $sql = "SELECT id_pembayaran, tipe_pembayaran, keterangan_pembayaran FROM jenis_pembayaran";
        $q = mysqli_query($this->conn, $sql) or die(false);
        $data = mysqli_fetch_all($q,MYSQLI_ASSOC);
        mysqli_free_result($q);

        return $data;
    }

    function getMobil($idClient) {
        $sql = "SELECT a.id_kendaraan as id, b.nama_brand_mobil as brand, a.produk_mobil as jenis, a.tahun, a.warna, a.nopol, a.nama_pemilik as pemilik FROM usr_mobil a JOIN brand_mobil b ON b.nama_brand_mobil = a.nama_brand WHERE id_user = '$idClient' ";
        $q = mysqli_query($this->conn, $sql) or die(false);
        $data = mysqli_fetch_all($q,MYSQLI_ASSOC);
        mysqli_free_result($q);

        return $data;
    }

    function getBrandMobil() {
      $sql = "SELECT id_brand_mobil as id, nama_brand_mobil as nama FROM brand_mobil";
      $q = mysqli_query($this->conn, $sql);
      $data = mysqli_fetch_all($q,MYSQLI_ASSOC);
      mysqli_free_result($q);

      return $data;
    }

    function createOrder($form) {
        $raws = explode(";;", base64_decode($form));
        if (count($raws) != 17) {
            return false;
        }
        $sql = "INSERT INTO order_cuci (id_usr_ord_fk, id_mbl_usr, invoice, lokasi, tanggal, jam, paket, pembayaran, status)
                VALUES ('$raws[0]', '$raws[13]', '$raws[1]', '$raws[7]', '$raws[8]', '$raws[9]', '$raws[10]', '$raws[11]', '$raws[12]')";
        $q = mysqli_query($this->conn, $sql);
        $status = false;
        if ($q) {
            $admin = $raws[16];
            $to = $raws[5];

            $subject = "Invoice Order Cucikan " . $raws[1];
            $adminsubject = "Invoice Order Cucikan " . $raws[1];

            $adminmessage = "Order \r\n";
            $adminmessage .="Mobil : " . $raws[2] . " " . $raws[3] ."\r\n";
            $adminmessage .="Pemilik : " . $raws[4] . "\r\n";
            $adminmessage .="Email : " . $raws[5] . "\r\n";
            $adminmessage .="Telepon : " . $raws[6] . "\r\n";
            $adminmessage .="Lokasi : " . $raws[7] . "\r\n";
            $adminmessage .="Tanggal : " . date("d-m-Y", strtotime($raws[8])) . "\r\n";
            $adminmessage .="Jam : " . $raws[9] . "\r\n";
            $adminmessage .="Paket Layanan : " . $raws[14] . "\r\n";
            $adminmessage .="Harga : Rp " . $raws[15] . ",-\r\n";
            $adminmessage .="Pembayaran : Cash";

            $message = "Dear customer,\r\n";
            $message .="Terima kasih telah melakukan order layanan kami. Berikut kami informasikan kembali detail pemesanan anda.\r\n";
            $message .="\r\n";
            $message .="ORDER INVOICE " . $raws[1] . "\r\n";
            $message .="\r\n";
            $message .="Mobil : " . $raws[2] . " " . $raws[3] ."\r\n";
            $message .="Pemilik : " . $raws[4] . "\r\n";
            $message .="Email : " . $raws[5] . "\r\n";
            $message .="Telepon : " . $raws[6] . "\r\n";
            $message .="Lokasi : " . $raws[7] . "\r\n";
            $message .="Tanggal : " . date("d-m-Y", strtotime($raws[8])) . "\r\n";
            $message .="Jam : " . $raws[9] . "\r\n";
            $message .="Paket Layanan : " . $raws[14] . "\r\n";
            $message .="Harga : Rp " . $raws[15] . ",-\r\n";
            $message .="Pembayaran : Cash";
            $message .="\r\n";
            $message .="\r\n";
            $message .="Terus gunakan layanan kami untuk menjaga kebersihan mobil anda.\r\n";
            $message .="Salam, Cucikan. \r\n";
            $message = wordwrap($message,70);

            $adminheaders = "From: Cucikan <" . '$raws[16]' . ">\r\n";
            $adminheaders .= "Reply-To: admin@cucikan.com\r\n";
            $adminheaders .= "Return-Path: admin@cucikan.com\r\n";

            $headers = "From: Cucikan <" . '$raws[16]' . ">\r\n";
            $headers .= "Reply-To: admin@cucikan.com\r\n";
            $headers .= "Return-Path: admin@cucikan.com\r\n";

            mail($to,$subject,$message,$headers);
            mail($admin,$adminsubject,$adminmessage,$adminheaders);
        }
        if ($q) {
            $status = true;
        }
        return $status;
    }

    function createMobil($form) {
        $raws = explode(";;", base64_decode($form));
        if (count($raws) != 7) {
            return false;
        }
        $sql = "INSERT INTO usr_mobil (id_user, nama_brand, produk_mobil, tahun, warna, nama_pemilik, nopol)
                VALUES ('$raws[0]', '$raws[1]', '$raws[2]', '$raws[3]', '$raws[4]', '$raws[5]', '$raws[6]')";
        $q = mysqli_query($this->conn,$sql);
        $status = false;
        if ($q) {
            $status = true;
        }

        return $status;
    }

    function deleteMobil($id) {
        $sql = "DELETE FROM usr_mobil WHERE id_kendaraan = $id";
        $q = mysqli_query($this->conn,$sql) or die('false');
        $status = false;
        if ($q) {
            $status - true;
        }

        return $status;
    }

    function updateUser($form) {
        $raws = explode(";;", base64_decode($form));
        $sql = "UPDATE usr_detail a
                INNER JOIN usr b ON a.id_user = b.id
                SET a.nama = '$raws[1]', a.gender = '$raws[2]', a.alamat = '$raws[3]', a.kota_kab = '$raws[4]', a.kecamatan = '$raws[5]', a.telepon = '$raws[6]', b.email = '$raws[7]'
                WHERE a.id_user = $raws[0]";
        $q = mysqli_query($this->conn,$sql) or die('false');
        $status = false;
        if ($q) {
            $status = true;
        }
        return $status;
    }

    function checkPass($id, $pass) {
        $sql = "SELECT id, salt, password FROM usr WHERE id = $id AND usrcred = 2 LIMIT 1";
        $q = mysqli_query($this->conn, $sql) or die('false');
        $data = mysqli_fetch_array($q);
        mysqli_free_result($q);
        $id = $data['id'];
        $salt = $data['salt'];
        $check = hash('sha256', $pass . $salt);
        for($round = 0; $round < 65536; $round++) {
            $check = hash('sha256', $check . $salt);
        }
        if ($check === $data['password']) {
            return true;
        } else {
            return false;
        }
    }

    function changePassword($id, $pass) {
        if ($pass == NULL) {
            return false;
        }
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $pass . $salt);
        for($round = 0; $round < 65536; $round++) {
            $password = hash('sha256', $password . $salt);
        }
        $sql = "UPDATE usr SET password = '$password', salt = '$salt' WHERE id = $id";
        $q = mysqli_query($this->conn, $sql) or die('false');
        $status = false;
        if ($q) {
            $status = true;
        }
        return $status;
    }

}
