<?php session_start();


include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_lama']);
$potongan = angkadoang($_POST['potongan']);
$harga = angkadoang($_POST['harga']);
$tax = stringdoang($_POST['jumlah_tax']);
$jumlah_tax = round($tax);
$subtotal = angkadoang($_POST['subtotal']);
$id = stringdoang($_POST['id']);

$session_id = session_id();


$query = $db->prepare("UPDATE tbs_penjualan_order SET jumlah_barang = ?, subtotal = ?, tax = ? WHERE id = ?");

$query = $db->prepare("UPDATE tbs_penjualan_order SET jumlah_barang = ?, subtotal = ?, tax = ? WHERE id = ?");


$query->bind_param("iiii",
    $jumlah_baru, $subtotal, $jumlah_tax, $id);

$query->execute();

    $query9 = $db->query("SELECT nama_petugas, kode_produk FROM tbs_fee_produk WHERE session_id = '$session_id' AND kode_produk = '$kode_barang' ");
    while($cek9 = mysqli_fetch_array($query9))
    {

        $select_fee = $db->query("SELECT jumlah_uang,jumlah_prosentase FROM fee_produk WHERE nama_petugas = '$cek9[nama_petugas]' AND kode_produk = '$cek9[kode_produk]' ");
        $ff = mysqli_fetch_array($select_fee);

        $nominal = $ff['jumlah_uang'];
        $prosentase = $ff['jumlah_prosentase'];
        $nm_pet = $cek9['nama_petugas'];

        if ($prosentase != 0){

            $fee_prosentase_produk = $prosentase * $subtotal / 100;
            $query1 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_prosentase_produk' WHERE nama_petugas = '$nm_pet' AND kode_produk = '$kode_barang' AND session_id = '$session_id'");
        }

       elseif ($nominal != 0){
                
            $fee_nominal_produk = $nominal * $jumlah_baru;
            $query01 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_nominal_produk' WHERE nama_petugas = '$nm_pet' AND kode_produk = '$kode_barang' AND session_id = '$session_id' ");
        }

  }
                //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>
