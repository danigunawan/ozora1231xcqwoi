<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

    



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 =>'no_faktur_order', 
  1 => 'kode_pelanggan',
  2 =>'tanggal', 
  3 => 'jam',
  4 => 'total',
  5 => 'keterangan',
  6 => 'Petugas_kasir',
  7 => 'id',
   
);




// getting total number records without any search
$sql = " SELECT po.keterangan,po.id,po.no_faktur_order,po.total,po.kode_pelanggan,po.tanggal,po.jam,po.user,po.status_order,pl.nama_pelanggan, t.nama_toko, po.nama_konsumen, po.alamat_konsumen,po.invoice_marketplace,po.no_telpon_konsumen, po.toko";
$sql.=" FROM penjualan_order po INNER JOIN pelanggan pl ON po.kode_pelanggan = pl.id INNER JOIN toko t ON po.toko = t.id WHERE po.status_order = 'Diorder' ";
$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT  po.keterangan,po.id,po.no_faktur_order,po.total,po.kode_pelanggan,po.tanggal,po.jam,po.user,po.status_order,pl.nama_pelanggan, t.nama_toko, po.nama_konsumen, po.alamat_konsumen,po.invoice_marketplace,po.no_telpon_konsumen, po.toko";
$sql.=" FROM penjualan_order po INNER JOIN pelanggan pl ON po.kode_pelanggan = pl.id INNER JOIN toko t ON po.toko = t.id WHERE po.status_order = 'Diorder' AND 1=1 ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( po.no_faktur_order LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR po.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.total LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.tanggal LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.kode_gudang LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR t.nama_toko LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.nama_konsumen LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.invoice_marketplace LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR po.no_telpon_konsumen LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY po.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

    $query_pelanggan = $db->query("SELECT kode_pelanggan FROM pelanggan WHERE id = '$row[kode_pelanggan]'");
    $data_pelanggan = mysqli_fetch_array($query_pelanggan);


    $nestedData[] = $row['no_faktur_order'];
    $nestedData[] = $row['invoice_marketplace'];
    $nestedData[] = $data_pelanggan['kode_pelanggan'] ." - ".$row['nama_pelanggan'];
    $nestedData[] = $row['nama_toko'];
    $nestedData[] = $row['nama_konsumen'];
    $nestedData[] = $row['tanggal'];
    $nestedData[] = $row['jam'];
    $nestedData[] = rp($row['total']);
    $nestedData[] = $row['keterangan'];
    $nestedData[] = $row['user'];
    $nestedData[] = $row['alamat_konsumen'];
    $nestedData[] = $data_pelanggan['kode_pelanggan'];
    $nestedData[] = $row['toko'];
    $nestedData[] = $row['no_telpon_konsumen'];
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



    

