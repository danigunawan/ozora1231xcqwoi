<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

    
    0=>'Nama Ekspedisi',
    1=>'Hapus',
    2=>'Edit',
    3=>'id' 

);

// getting total number records without any search
$sql =" SELECT id,nama_ekspedisi ";
$sql.=" FROM ekspedisi ";
$sql.="";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT id,nama_ekspedisi ";
$sql.=" FROM ekspedisi ";
$sql.=" WHERE 1=1 ";

    $sql.=" AND (nama_ekspedisi LIKE '".$requestData['search']['value']."%' )";  
}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array();

         $query_otoritas_master_data_ekspedisi = $db->query("SELECT ekspedisi_edit,ekspedisi_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
		$data_otoritas_master_data_ekspedisi = mysqli_fetch_array($query_otoritas_master_data_ekspedisi);


          $nestedData[] = $row['nama_ekspedisi'];
          if ($data_otoritas_master_data_ekspedisi['ekspedisi_hapus'] == 1){

    $query_cek_ekspedisi = $db->query("SELECT kode_ekspedisi FROM penjualan WHERE kode_ekspedisi = '$row[id]' ");
              $jumlah_cek_ekspedisi = mysqli_num_rows($query_cek_ekspedisi);

      $query_cek_ekspedisi_resi = $db->query("SELECT nama_expedisi FROM resi WHERE nama_expedisi = '$row[id]' ");
              $jumlah_cek_ekspedisi_resi = mysqli_num_rows($query_cek_ekspedisi_resi);

       if ($jumlah_cek_ekspedisi == 0 AND $jumlah_cek_ekspedisi_resi == 0){

        $nestedData[] = "<button class='btn btn-danger btn-hapus btn-sm' data-id='". $row['id'] ."' data-ekspedisi='". $row['nama_ekspedisi'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";

      }
      else{
      $nestedData[] = "<p style='color:red;'>Sudah Terpakai</p>";
      }

          

          }
          else{
			$nestedData[] = "<p></p>";
          }

          if ($data_otoritas_master_data_ekspedisi['ekspedisi_edit'] == 1){
          $nestedData[] = "<button class='btn btn-success btn-edit btn-sm' data-ekspedisi='". $row['nama_ekspedisi'] ."' data-id='". $row['id'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button>";
      	  }
      	  else{
			$nestedData[] = "<p></p>";
      	  }

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