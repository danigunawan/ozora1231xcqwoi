<?php 

include 'db.php';

$session_id = $_POST['session_id'];

$query = $db->query("SELECT kode_barang FROM tbs_penjualan_order WHERE session_id = '$session_id'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>
