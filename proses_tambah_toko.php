<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';
 
    // mengirim data menggunakan metode POST


    $perintah = $db->prepare("INSERT INTO toko (id,nama_toko,alamat_toko,no_toko) VALUES (?,?,?,?)");

    $perintah->bind_param("ssss",
        $id, $nama_toko, $alamat_toko, $no_toko);
        
        $id = stringdoang($_POST['id']);
        $nama_toko = stringdoang($_POST['nama_toko']); 
        $alamat_toko = stringdoang($_POST['alamat_toko']);   
        $no_toko = stringdoang($_POST['no_toko']);  
    
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