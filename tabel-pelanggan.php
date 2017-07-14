
<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';



$query_otoritas_pelanggan = $db->query("SELECT pelanggan_tambah, pelanggan_hapus,pelanggan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$data_otoritas_pelanggan = mysqli_fetch_array($query_otoritas_pelanggan);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'id'
);


// getting total number records without any search
$sql = "SELECT kode_pelanggan,nama_pelanggan,flafon,flafon_usia,level_harga,no_telp,e_mail,wilayah,id,tgl_lahir ";
$sql.=" FROM pelanggan ";

$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.



$sql = "SELECT kode_pelanggan,nama_pelanggan,flafon,flafon_usia,level_harga,no_telp,e_mail,wilayah,id,tgl_lahir ";
$sql.=" FROM pelanggan WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( kode_pelanggan LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR level_harga LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 


    	//menampilkan data
			$nestedData[] = $row['kode_pelanggan'];
			$nestedData[] = $row['nama_pelanggan'];
			$nestedData[] = rp($row['flafon']);
			$nestedData[] = $row['flafon_usia'];
			$nestedData[] = $row['level_harga'];
			$nestedData[] = $row['no_telp'];
			$nestedData[] = $row['e_mail'];
			$nestedData[] = $row['wilayah'];
			
 if ($data_otoritas_pelanggan['pelanggan_hapus'] > 0){


			$nestedData[] = " <button class='btn btn-danger btn-hapus btn-sm' data-id='". $row['id'] ."' data-pelanggan='". $row['nama_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> ";

		}

    if ($data_otoritas_pelanggan['pelanggan_hapus'] > 0){
			$nestedData[] = " <button class='btn btn-info btn-edit btn-sm' data-pelanggan='". $row['nama_pelanggan'] ."' data-kode='". $row['kode_pelanggan'] ."' data-tanggal='". $row['tgl_lahir'] ."' data-nomor='". $row['no_telp'] ."' data-email='". $row['e_mail'] ."' data-wilayah='". $row['wilayah'] ."' data-level-harga='". $row['level_harga'] ."' data-id='". $row['id'] ."' data-flafon='". $row['flafon'] ."' data-flafon-usia='". $row['flafon_usia'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> ";
		}

				$nestedData[] = $row["id"];

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

