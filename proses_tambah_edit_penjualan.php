<?php session_start();
 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $nomor_faktur = stringdoang($_POST['no_faktur']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = stringdoang($_POST['jumlah_barang']);
    $satuan = stringdoang($_POST['satuan']);
    $harga = stringdoang($_POST['harga']);
    $harga_baru = stringdoang($_POST['harga_baru']);
    $potongan = stringdoang($_POST['potongan']);
    $tax = stringdoang($_POST['tax']);
    $level_harga = stringdoang($_POST['level_harga']);

    $a = $harga * $jumlah_barang;
    $tahun_sekarang = date('Y');
    $bulan_sekarang = date('m');
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:sa');
    $tahun_terakhir = substr($tahun_sekarang, 2);

    
    $subtotal = $harga * $jumlah_barang - $potongan;



    $tax = stringdoang($_POST['tax']);
    $satu = 1;

    $hasil_tax = $satu + ($tax / 100);

    $hasil_tax2 = $subtotal / $hasil_tax;

    $tax_jadi = $subtotal - $hasil_tax2;


        $perintah = "INSERT INTO tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax)VALUES ('$nomor_faktur','$kode_barang','$nama_barang','$jumlah_barang','$satuan','$harga','$subtotal','$potongan','$tax_jadi')";
        
        if ($db->query($perintah) === TRUE)
        {
        }
        else
        {
            echo "Error: " . $perintah . "<br>" . $db->error;
        }

 echo"</tr>";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
