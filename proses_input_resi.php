<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';
 
    // mengirim data menggunakan metode POST


    $perintah = $db->prepare("INSERT INTO resi (id_penjualan,nomor_resi,nama_expedisi) VALUES (?,?,?)");

    $perintah->bind_param("iss",$id,$nomor_resi,$nama_expedisi);
        
        $id = stringdoang($_POST['id_penjualan']);
        $nomor_resi = stringdoang($_POST['nomor_resi']);  
        $nama_expedisi = stringdoang($_POST['ekspedisi']);  

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