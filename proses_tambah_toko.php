<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';
 
    // mengirim data menggunakan metode POST


    $perintah = $db->prepare("INSERT INTO toko (id,nama_toko,alamat_toko,kode_marketplace) VALUES (?,?,?,?)");

    $perintah->bind_param("ssss",
        $id, $nama_toko, $alamat_toko, $kode_marketplace);
        
        $id = stringdoang($_POST['id']);
        $nama_toko = stringdoang($_POST['nama_toko']); 
        $alamat_toko = stringdoang($_POST['alamat_toko']);   
        $kode_marketplace = stringdoang($_POST['kode_marketplace']);  
    
    $perintah->execute();



if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo "sukses";
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>