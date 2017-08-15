<?php 

include 'db.php';

$varian_ukuran = $_POST['varian_ukuran'];

$query_varian = $db->query("SELECT varian_ukuran FROM varian_ukuran WHERE varian_ukuran = '$varian_ukuran'");
$query_varian_ukuran = mysqli_num_rows($query_varian);


if ($query_varian_ukuran > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

