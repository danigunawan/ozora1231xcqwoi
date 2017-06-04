<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

        $nomor_faktur = stringdoang($_POST['no_faktur']);
        $jam_sekarang = date('H:i:s');
        $tanggal = stringdoang($_POST['tanggal']);
        $waktu = $tanggal." ".$jam_sekarang;
        $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);

        $query_hapus = $db->query("DELETE FROM detail_penjualan_order WHERE no_faktur_order = '$nomor_faktur' ");

        $query_select_tbs = $db->query("SELECT * FROM tbs_penjualan_order WHERE no_faktur_order = '$nomor_faktur' ");
            while ($data = mysqli_fetch_array($query_select_tbs)){

                $query_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[harga] * $data[jumlah_barang] / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND kode_produk = '$data[kode_barang]'");
                $data_konversi = mysqli_fetch_array($pilih_konversi);

                if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
                    $harga = $data_konversi['harga_konversi'];
                    $jumlah_barang = $data_konversi['jumlah_konversi'];
                    $satuan = $data_konversi['satuan'];
                }
                else{
                    $harga = $data['harga'];
                    $jumlah_barang = $data['jumlah_barang'];
                    $satuan = $data['satuan'];
                }

                $query_insert = "INSERT INTO detail_penjualan_order (no_faktur_order,kode_barang, nama_barang, jumlah_barang,satuan, harga, subtotal, potongan, tax,tanggal,jam,asal_satuan) VALUES ('$nomor_faktur','$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$data[tanggal]','$data[jam]','$satuan')";

                       if ($db->query($query_insert) === TRUE) {
                       }                       
                       else {
                            echo "Error: " . $query_insert . "<br>" . $db->error;
                       }
                       
            }

        // buat prepared statements
        $query_update = $db->prepare("UPDATE penjualan_order SET toko = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, user = ? , keterangan = ?, nama_konsumen = ?, alamat_konsumen = ?, sales = ? WHERE no_faktur_order = ?");          
            
        // hubungkan "data" dengan prepared statements
        $query_update->bind_param("isissssssis", 
        $nama_toko, $kode_pelanggan, $total, $tanggal, $jam_sekarang , $user, $keterangan, $nama_konsumen, $alamat_konsumen, $sales, $nomor_faktur);
            
        // siapkan "data" query
        $nama_toko = angkadoang($_POST['nama_toko']);
        $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
        $total = angkadoang($_POST['total2']);
        $keterangan = stringdoang($_POST['keterangan']);
        $sales = angkadoang($_POST['sales']);
        $user = $_SESSION['nama'];
        $tanggal = stringdoang($_POST['tanggal']);
        $nama_konsumen = stringdoang($_POST['nama_konsumen']);
        $alamat_konsumen = stringdoang($_POST['alamat_konsumen']);
        $nomor_faktur = stringdoang($_POST['no_faktur']);
            
        // jalankan query            
        $query_update->execute();

        $perintah2 = $db->query("DELETE FROM tbs_penjualan_order WHERE no_faktur_order = '$nomor_faktur'");

        // cek query
        if (!$query_update) {
           die('Query Error : '.$db->errno.
           ' - '.$db->error);
        }
        else {

        }

        echo "Success";
        
        //Untuk Memutuskan Koneksi Ke Database
        mysqli_close($db);
?>