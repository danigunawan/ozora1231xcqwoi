<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];


$query = $db->query("SELECT * FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");



?>
					<div class="container">
					
					<div class="table-responsive">
					<table id="tableuser" class="table table-bordered">
					<thead>
					<th> Nomor Faktur Pembayaran</th>
					<th> Nomor Faktur Penjualan </th>
					<th> Tanggal </th>
					<th> Tanggal Jatuh Tempo </th>
					<th> Kredit </th>
					<th> Potongan </th>
					<th> Jumlah Bayar </th>					
					<th> Sisa Kredit </th>
					</thead>
					
					
					<tbody>
					
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{

      				$sisa_kredit = $data1['kredit'] - ($data1['jumlah_bayar'] + $data1['potongan']);

					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur_pembayaran'] ."</td>
					<td>". $data1['no_faktur_penjualan'] ."</td>
					<td>". $data1['tanggal'] ."</td>
					<td>". $data1['tanggal_jt'] ."</td>
					<td>". $data1['kredit'] ."</td>
					<td>". rp($data1['potongan']) ."</td>
					<td>". rp($data1['jumlah_bayar']) ."</td>
					<td>". rp($sisa_kredit) ."</td>
					</tr>";
					}
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 					
					?>
					
					</tbody>
					</table>
					</div>
					</div>