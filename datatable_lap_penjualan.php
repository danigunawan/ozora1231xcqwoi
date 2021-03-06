<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';


$query_sum = $db->query("SELECT SUM(total) AS total_bersih, SUM(potongan) AS total_potongan, SUM(tax) AS total_tax, SUM(tunai) AS total_tunai, SUM(sisa) AS total_sisa, SUM(ongkir) AS total_ongkir FROM penjualan");
$data_sum = mysqli_fetch_array($query_sum);

$sub_total_bersih = $data_sum['total_bersih'];
$sub_total_potongan = $data_sum['total_potongan'];
$sub_total_tax = $data_sum['total_tax'];
$sub_total_ongkir = $data_sum['total_ongkir'];
$sub_total_tunai = $data_sum['total_tunai'];
$sub_total_sisa = $data_sum['total_sisa'];

$jumlah_total_kotor = $db->query("SELECT SUM(subtotal) AS total_kotor FROM detail_penjualan");
$ambil_kotor = mysqli_fetch_array($jumlah_total_kotor);

$sub_total_kotor = $ambil_kotor['total_kotor'];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama_pelanggan', 
	1 => 'total',
	2 => 'no_faktur',
	3=> 'kode_pelanggan',
	4=> 'tanggal',
	5=> 'jam ',
	6=> 'user',
	7=> 'status',
	8=> 'potongan',
	9=> 'tax',
	10=> 'sisa',
	11=> 'id'
);

// getting total number records without any search
$sql = "SELECT pel.nama_pelanggan,pel.kode_pelanggan,p.tunai,p.id,p.total,p.no_faktur,p.kode_pelanggan,p.tanggal,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa, p.nama_konsumen, t.nama_toko,p.ongkir ";
$sql.="FROM penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.kode_pelanggan INNER JOIN toko t ON p.kode_toko = t.id ";
$query=mysqli_query($conn, $sql) or die("datatable_lap_penjualan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT pel.nama_pelanggan,pel.kode_pelanggan AS code_card,p.tunai,p.id,p.total,p.no_faktur,p.kode_pelanggan,p.tanggal,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa, p.nama_konsumen, t.nama_toko,p.ongkir ";
$sql.="FROM penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.kode_pelanggan INNER JOIN toko t ON p.kode_toko = t.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( pel.nama_pelanggan LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.nama_konsumen LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_lap_penjualan.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    			$sum_subtotal = $db->query("SELECT SUM(subtotal) AS total_kotor FROM detail_penjualan WHERE no_faktur = '$row[no_faktur]' ");

				$ambil_sum_subtotal = mysqli_fetch_array($sum_subtotal);
				$total_kotor = $ambil_sum_subtotal['total_kotor'];

					//menampilkan data
					$nestedData[] = $row['no_faktur'];
					$nestedData[] = $row['code_card'] ." - ". $row['nama_pelanggan'];
					$nestedData[] = $row['nama_toko'];
					$nestedData[] = $row['nama_konsumen'];
					$nestedData[] = rp($total_kotor);
					$nestedData[] = rp($row['total']);
					$nestedData[] = $row['tanggal'];
					$nestedData[] = $row['jam'];
					$nestedData[] = $row['user'];
					$nestedData[] = $row['status'];
					$nestedData[] = rp($row['potongan']);
					$nestedData[] = rp($row['tax']);
					$nestedData[] = rp($row['ongkir']);
					$nestedData[] = rp($row['tunai']);
					$nestedData[] = rp($row['sisa']);
					$nestedData[] = $row["id"];

				$data[] = $nestedData;
			}

				$nestedData=array(); 
					//menampilkan data
					$nestedData[] = "<b style='color:red'>TOTAL<b>";
					$nestedData[] = "<b style='color:red'>-<b>";
					$nestedData[] = "<b style='color:red'>-<b>";
					$nestedData[] = "<b style='color:red'>-<b>";
					$nestedData[] = "<b style='color:red'>".rp($sub_total_kotor)."<b>";
					$nestedData[] = "<b style='color:red'>".rp($sub_total_bersih)."<b>";
					$nestedData[] = "<b style='color:red'>-<b>";
					$nestedData[] = "<b style='color:red'>-<b>";
					$nestedData[] = "<b style='color:red'>-<b>";
					$nestedData[] = "<b style='color:red'>-<b>";
					$nestedData[] = "<b style='color:red'>".rp($sub_total_potongan)."<b>";
					$nestedData[] = "<b style='color:red'>".rp($sub_total_tax)."<b>";
					$nestedData[] = "<b style='color:red'>".rp($sub_total_ongkir)."<b>";
					$nestedData[] = "<b style='color:red'>".rp($sub_total_tunai)."<b>";
					$nestedData[] = "<b style='color:red'>".rp($sub_total_sisa)."<b>";
					$nestedData[] = "<b style='color:red'>-<b>";

				$data[] = $nestedData;



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>

