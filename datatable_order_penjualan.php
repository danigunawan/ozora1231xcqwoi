<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

    
$pilih_akses_penjualan = $db->query("SELECT penjualan_edit, penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$data_akses = mysqli_fetch_array($pilih_akses_penjualan);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'cetak_order', 
  1 => 'detail',
  2 =>'cetak_order', 
	3 => 'detail',
	4 => 'kode_pelanggan',
	5 => 'kode_gudang',
	6 => 'tanggal',
  7 => 'jam',
  8 => 'petugas_kasir',
  9 => 'total',
  10 => 'status_order',
  11 => 'keterangan',
  12 => 'id'
);




// getting total number records without any search
$sql = " SELECT pl.kode_pelanggan,po.keterangan,po.toko,po.nama_konsumen,po.alamat_konsumen,po.id,po.no_faktur_order,po.total,po.tanggal,po.jam,po.user,po.status_order,pl.nama_pelanggan, t.nama_toko ";
$sql.=" FROM penjualan_order po INNER JOIN toko t ON po.toko = t.id INNER JOIN pelanggan pl ON po.kode_pelanggan = pl.id ";
$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT  pl.kode_pelanggan,po.keterangan,po.toko,po.nama_konsumen,po.alamat_konsumen,po.id,po.no_faktur_order,po.total,po.kode_pelanggan,po.tanggal,po.jam,po.user,po.status_order,pl.nama_pelanggan, t.nama_toko  ";
$sql.=" FROM penjualan_order po INNER JOIN toko t ON po.toko = t.id INNER JOIN pelanggan pl ON po.kode_pelanggan = pl.id  WHERE 1=1 ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( po.no_faktur_order LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.total LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.tanggal LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR t.nama_toko LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.user LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.nama_konsumen LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY po.id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 



    if ($data_akses['penjualan_edit'] > 0){
      if ($row['status_order'] != 'Dijual') {
        $nestedData[] = "<a href='proses_edit_penjualan_order.php?no_faktur=". $row['no_faktur_order']."&kode_pelanggan=". $row['kode_pelanggan']."&nama_pelanggan=". $row['nama_pelanggan']."&nama_toko=".$row['nama_toko']."&id_toko=".$row['toko']."' class='btn btn-success btn-sm'>Edit</a>";
      }
      else{
        $nestedData[] = "<p align='center'>x</p>";
      }      
    }

    if ($data_akses['penjualan_hapus'] > 0){
      if ($row['status_order'] != 'Dijual') {
        $nestedData[] = "<button class='btn btn-danger btn-hapus btn-sm' data-id='".$row['id']."' data-pelanggan='".$row['nama_pelanggan']."' data-faktur='".$row['no_faktur_order']."' >Hapus</button>";
      }
      else{
        $nestedData[] = "<p align='center'>x</p>";
      }      
    }
    $nestedData[] = "<a href='cetak_penjualan_order.php?no_faktur=".$row['no_faktur_order']."' class='btn btn-primary btn-sm' target='blank'> Cetak  </a>";

    $nestedData[] = "<button class='btn btn-info btn-sm detail' no_faktur='". $row['no_faktur_order'] ."' >Detail</button>";
    $nestedData[] = $row['no_faktur_order'];
    $nestedData[] = $row['nama_toko'];
    $nestedData[] = $row['kode_pelanggan'] ." - ".$row['nama_pelanggan'];
    $nestedData[] = $row['nama_konsumen'];
    $nestedData[] = $row['tanggal'];
    $nestedData[] = $row['jam'];
    $nestedData[] = $row['user'];
    $nestedData[] = rp($row['total']);
    
    if ($row['status_order'] == 'Diorder') {
      $nestedData[] = "<p style='color:blue;'>".$row['status_order']."</p>";
    }
    else{
      $nestedData[] = "<p style='color:red;'>".$row['status_order']."</p>";
    }
    
    $nestedData[] = $row['keterangan'];
    $nestedData[] = $row['id'];

	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>



    

