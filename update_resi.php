<?php
  // memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);
   




if ($jenis_edit == 'nomor_resi') {
    
    $input_nomor_resi_baru = stringdoang($_POST['input_nomor_resi_baru']);

       $query =$db->prepare("UPDATE resi SET nomor_resi = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_nomor_resi_baru, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}
// UPDATE nomor_resi

if ($jenis_edit == 'nama_expedisi') {

    $nama_expedisi = stringdoang($_POST['input_nama_expedisi']);

       $query =$db->prepare("UPDATE resi SET nama_expedisi = ?  WHERE id = ?");

       $query->bind_param("si",
        $nama_expedisi, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

      $manggil_ekspedisi = $db->query("SELECT nama_ekspedisi FROM ekspedisi WHERE id = '$nama_expedisi' ");
      $data_ekspedisi = mysqli_fetch_array($manggil_ekspedisi);
      echo $ekspedisi = $data_ekspedisi['nama_ekspedisi'];

}
// UPDATE HARGA JUAL 1





  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>