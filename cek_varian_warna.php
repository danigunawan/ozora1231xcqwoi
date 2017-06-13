<?php 

include 'db.php';

$varian_warna = $_POST['varian_warna'];

$query_varian = $db->query("SELECT varian_warna FROM varian_warna WHERE varian_warna = '$varian_warna'");
$query_varian_ukuran = mysqli_num_rows($query_varian);


if ($query_varian_ukuran > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

