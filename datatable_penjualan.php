<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';
 $status = $_POST['status'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'total',
    2 => 'kode_pelanggan',
    3 => 'tanggal',
    4 => 'tanggal_jt',
    5 => 'jam',
    6 => 'user',
    7 => 'sales',
    8 => 'kode_meja',
    9 => 'status',
    10 => 'potongan',
    11 => 'tax',
    12 => 'sisa',
    13 => 'kredit',
    14 => 'nama_gudang',
    15 => 'kode_toko', 
    16 => 'nama_pelanggan',
	17 => 'id',
	18 => 'nama_konsumen',
	19 => 'alamat_konsumen',
	20 => 'invoice_marketplace',
	21 => 'no_telpon_konsumen',
	22 => 'status_cetak',
);



if ($status == 'semua') {
// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.tunai, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nama_konsumen,p.alamat_konsumen,p.invoice_marketplace,p.status_cetak,p.no_telpon_konsumen,p.kode_ekspedisi,g.nama_gudang,p.kode_gudang,t.nama_toko,p.kode_toko,pl.nama_pelanggan ";
$sql.="FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN toko t ON p.kode_toko = t.id INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan ";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
}
else{
	// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.tunai, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nama_konsumen,p.alamat_konsumen,p.invoice_marketplace,p.status_cetak,p.no_telpon_konsumen,p.kode_ekspedisi,g.nama_gudang,p.kode_gudang,t.nama_toko,p.kode_toko,pl.nama_pelanggan,p.keterangan ";
$sql.="FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN toko t ON p.kode_toko = t.id INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan ";
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
}


if ($status == 'semua') {
// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.tunai, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nama_konsumen,p.alamat_konsumen,p.invoice_marketplace,p.status_cetak,p.no_telpon_konsumen,p.kode_ekspedisi,g.nama_gudang,p.kode_gudang,t.nama_toko,p.kode_toko,pl.nama_pelanggan,p.keterangan ";
$sql.="FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN toko t ON p.kode_toko = t.id INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan  WHERE 1=1"; 
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR g.nama_gudang LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR t.nama_toko LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR p.kode_meja LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.nama_konsumen LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR p.invoice_marketplace LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.no_telpon_konsumen LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR p.alamat_konsumen LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR p.sales LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

	}
}
else{
// getting total number records without any search
$sql = "SELECT pl.kode_pelanggan AS code_card, p.tunai, p.id,p.no_faktur,p.total,p.kode_pelanggan,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nama_konsumen,p.alamat_konsumen,p.invoice_marketplace,p.status_cetak,p.no_telpon_konsumen,p.kode_ekspedisi,g.nama_gudang,p.kode_gudang,t.nama_toko,p.kode_toko,pl.nama_pelanggan,p.keterangan ";
$sql.="FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang INNER JOIN toko t ON p.kode_toko = t.id INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan WHERE p.status = '$status' AND 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR g.nama_gudang LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR t.nama_toko LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR p.kode_meja LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.nama_konsumen LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.invoice_marketplace LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.no_telpon_konsumen LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR p.alamat_konsumen LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR p.sales LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR p.jam LIKE '".$requestData['search']['value']."%' )";

	}
}
$query=mysqli_query($conn, $sql) or die("datatable_item_keluar.phpppp: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

    	$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){

			$nestedData[] = "<a href='proses_edit_penjualan.php?no_faktur=". $row['no_faktur']."&kode_pelanggan=". $row['kode_pelanggan']."&nama_gudang=".$row['nama_gudang']."&kode_gudang=".$row['kode_gudang']."&kode_toko=".$row['kode_toko']."&nama_toko=".$row['nama_toko']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."&kode_ekspedisi=".$row['kode_ekspedisi']."&invoice_marketplace=".$row['invoice_marketplace']."&no_telpon_konsumen=".$row['no_telpon_konsumen']."' class='btn btn-success'>Edit</a>";	


		}



$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


	if ($penjualan_hapus > 0){

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$row[no_faktur]'");
$row_retur = mysqli_num_rows($pilih);

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$row[no_faktur]'");
$row_piutang = mysqli_num_rows($pilih);

if ($row_retur > 0 || $row_piutang > 0) {

			$nestedData[] = "<button class='btn btn-danger btn-alert' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."'>Hapus</button>";

} 

else {

			$nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='".$row['id']."' data-pelanggan='".$row['nama_pelanggan']."' data-faktur='".$row['no_faktur']."' kode_meja='".$row['kode_meja']."'>Hapus</button>";
}




		}




if ($row['status'] == 'Lunas') {

	if ($row['status_cetak'] == '0') {
	$nestedData[] ="<div class='dropdown'>
				<button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' style='width:150px'> Cetak Penjualan <span class='caret'></span></button>
				
				<ul class='dropdown-menu'>
				<li><a href='cetak_penjualan_surat_jalan.php?no_faktur=".$row['no_faktur']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."&kode_toko=".$row['kode_toko']."&nama_toko=".$row['nama_toko']."&kode_ekspedisi=".$row['kode_ekspedisi']."&keterangan=".$row['keterangan']."' target='blank'> Cetak Label </a></li>
				<li><a href='cetak_lap_penjualan_tunai_besar.php?no_faktur=".$row['no_faktur']."&nama_toko=".$row['nama_toko']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."&kode_toko=".$row['kode_toko']."' target='blank'> Cetak Invoice </a></li>
				</ul>
				</div>";
	} 
	elseif ($row['status_cetak'] == '1') {
	$nestedData[] ="<div class='dropdown'>
				<button class='btn btn-success dropdown-toggle' type='button' data-toggle='dropdown' style='width:150px'> Cetak Penjualan <span class='caret'></span></button>
				
				<ul class='dropdown-menu'>
				<li><a href='cetak_penjualan_surat_jalan.php?no_faktur=".$row['no_faktur']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."&kode_toko=".$row['kode_toko']."&nama_toko=".$row['nama_toko']."&kode_ekspedisi=".$row['kode_ekspedisi']."&keterangan=".$row['keterangan']."' target='blank'> Cetak Label </a></li>
				<li><a href='cetak_lap_penjualan_tunai_besar.php?no_faktur=".$row['no_faktur']."&nama_toko=".$row['nama_toko']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."&kode_toko=".$row['kode_toko']."' target='blank'> Cetak Invoice </a></li>
				</ul>
				</div>";

	}
}

else{

	$nestedData[] = "";
}



if ($row['status'] == 'Piutang') {

	if ($row['status_cetak'] == '0') {
		$nestedData[] ="<div class='dropdown'>
				<button class='btn btn-warning dropdown-toggle' type='button' data-toggle='dropdown' style='width:150px'> Cetak Piutang <span class='caret'></span></button>
				
				<ul class='dropdown-menu'>
				<li><a href='cetak_lap_penjualan_piutang.php?no_faktur=".$row['no_faktur']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."' target='blank'> Cetak Piutang </a></li> 
				<li><a href='cetak_penjualan_surat_jalan.php?no_faktur=".$row['no_faktur']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."&kode_toko=".$row['kode_toko']."' target='blank'> Cetak Label </a></li>
				</ul>
				</div>";
    }
	elseif ($row['status_cetak'] == '1') {
		$nestedData[] ="<div class='dropdown'>
				<button class='btn btn-light-green dropdown-toggle' type='button' data-toggle='dropdown' style='width:150px'> Cetak Piutang <span class='caret'></span></button>
				
				<ul class='dropdown-menu'>
				<li><a href='cetak_lap_penjualan_piutang.php?no_faktur=".$row['no_faktur']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."' target='blank'> Cetak Piutang </a></li> 
				<li><a href='cetak_penjualan_surat_jalan.php?no_faktur=".$row['no_faktur']."&nama_konsumen=".$row['nama_konsumen']."&alamat_konsumen=".$row['alamat_konsumen']."&kode_toko=".$row['kode_toko']."' target='blank'> Cetak Label </a></li>
				</ul>
				</div>";
    }
    
}

else{

	$nestedData[] = "";
	
}

			$nestedData[] = "<button class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."' >Detail</button>";



$query_resi = $db->query("SELECT id,id_penjualan,nomor_resi,nama_expedisi FROM resi WHERE id_penjualan = '$row[id]' ");
$jumlah_resi = mysqli_num_rows($query_resi);

$query_resi_2 = $db->query("SELECT rs.id,rs.id_penjualan,rs.nomor_resi,eks.nama_ekspedisi  FROM resi rs  LEFT JOIN ekspedisi eks ON rs.nama_expedisi = eks.id WHERE rs.id_penjualan = '$row[id]' ");
$data_resi = mysqli_fetch_array($query_resi_2);

	
if ($jumlah_resi > 0) {
	# code...
	$nestedData[] = "<button style='background-color:#aa66cc;width:80px'' class='btn btn-info lihat_resi' id_penjualan='". $data_resi['id']."' nama_ekspedisi='". $data_resi['nama_ekspedisi'] ."' nomor_resi='". $data_resi['nomor_resi'] ."' ><i class='fa fa-search' aria-hidden='true'></i> Lihat</button>";
}
else{
	$nestedData[] = "<button style='background-color:#2BBBAD;width:80px'' class='btn btn-default input_resi' id_penjualan='". $row['id']."'' ><i class='fa fa-send' aria-hidden='true'></i> Input</button>";
}

			


			$nestedData[] = $row["no_faktur"]; 
			$nestedData[] = $row["invoice_marketplace"];
			$nestedData[] = $row["nama_toko"];			
			$nestedData[] = $row["nama_pelanggan"];
			$nestedData[] = $row["nama_konsumen"];
			$nestedData[] = $row["alamat_konsumen"];
			$nestedData[] = $row["no_telpon_konsumen"];
			$nestedData[] = rp($row["total"]);
			$nestedData[] = $row["tanggal"];
			$nestedData[] = $row["jam"];
			$nestedData[] = $row["tanggal_jt"];
			$nestedData[] = $row["user"];
			$nestedData[] = $row["sales"];
			$nestedData[] = $row["status"];
			$nestedData[] = rp($row["potongan"]);
			$nestedData[] = rp($row["tax"]);
			$nestedData[] = rp($row["tunai"]);
			$nestedData[] = rp($row["sisa"]);
			$nestedData[] = rp($row["kredit"]);

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

