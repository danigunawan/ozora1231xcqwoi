<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

?>



<div class="container">

<h3><b>DATA TOKO</b></h3> <hr>

<?php 
include 'db.php';

$pilih_akses_toko_tambah = $db->query("SELECT toko_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND toko_tambah = '1'");
$toko_tambah = mysqli_num_rows($pilih_akses_toko_tambah);

if ($toko_tambah > 0){
// Trigger the modal with a button -->
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> TOKO</button>';

}

?>
<br>
<br>



<div class="container">
<!-- Modal tambah data -->



<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Data Toko</h4>
      </div>
    <div class="modal-body">
<form role="form">
					<div class="form-group">
					<label> Nama Toko </label><br>
					<input type="text" name="nama_toko" id="nama_toko" class="form-control" autocomplete="off" required="" >
					</div>
					
					
					<div class="form-group">
					<label> Alamat Toko </label><br>
					<input type="text" name="alamat_toko" id="alamat_toko" class="form-control" autocomplete="off" required="" > 
					</div>
					
          <div class="form-group">
          <label> Nomor Telephone Toko </label><br>
          <input type="text" name="no_toko" id="no_toko" class="form-control" autocomplete="off" required="" > 
          </div>
					
					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>

 	</div><!-- end of modal body -->

					<div class ="modal-footer">
					<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
	</div>
	</div>

</div><!-- end of modal buat data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus toko</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama toko :</label>
     <input type="text" id="data_toko" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data toko</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Toko:</label>
     <input type="text" class="form-control" id="nama_edit" autocomplete="off"> 
    
   </div>
   
   <div class="form-group">
    <label for="email">Alamat Toko:</label>
     <input type="text" class="form-control" id="alamat_edit" autocomplete="off">
    
   </div> 
  
          <div class="form-group">
          <label> Nomor Telephone Toko </label><br>
          <input type="text" name="no_toko_edit" id="no_toko_edit" class="form-control" autocomplete="off" required="" > 
          </div>
           <input type="hidden" class="form-control" id="id_edit"> 
          
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<div class="table-responsive">
<span id="table-baru">
<table id="tabel_toko" class="table table-bordered table-sm">
    <thead>
      <th> Nama Toko </th> 
      <th> Alamat Toko </th> 
      <th> Nomor Telpon Toko </th> 
      <th> Hapus </th>
      <th> Edit </th>   
    </thead>
  </table>
</span>
</div>
</div>

 <script type="text/javascript">
  // ajax table toko
    $(document).ready(function(){

        $("#tabel_toko").DataTable().destroy();
          var dataTable = $('#tabel_toko').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"tabel-toko.php", // json datasource
            "data": function ( d ) {
                  d.status = status;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("# ").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[5]+'');
            },

      }); 
  });
</script>

<script>
    $(document).ready(function(){
//fungsi untuk menambahkan data
    $("#submit_tambah").click(function(){
    var nama_toko = $("#nama_toko").val();
    var alamat_toko = $("#alamat_toko").val();
    var no_toko = $("#no_toko").val();

		if (nama_toko == ""){
			alert("Nama Harus Diisi");
		}
		else if (alamat_toko == ""){
			alert("Alamat Harus Diisi");
		}
    else if (no_toko == ""){
      alert("Nomor Telphone Harus Diisi");
    }
  

    else{

    $.post('proses_tambah_toko.php',{nama_toko:nama_toko,alamat_toko:alamat_toko,no_toko:no_toko},function(data){

    if (data != '') {
    $("#nama_toko").val('');
    $("#alamat_toko").val('');
    $("#no_toko").val('');
    $(".alert").show('fast');
    
    setTimeout(tutupalert, 2000);
    $(".modal").modal("hide");
    }
    var tabel_toko = $('#tabel_toko').DataTable();
              tabel_toko.draw();  
    });
    }
    
    
    function tutupmodal() {
    
    }
    });

// end fungsi tambah data


  
//fungsi hapus data 
$(document).on('click', '.btn-hapus', function (e) {
    var nama_toko = $(this).attr("data-toko");
    var id = $(this).attr("data-id");
    $("#data_toko").val(nama_toko);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    
    });


$(document).on('click', '#btn_jadi_hapus', function (e) {
    
    var id = $("#id_hapus").val();
    $.post("proses_hapus_toko.php",{id:id},function(data){
    if (data != "") { 
    $("#modal_hapus").modal('hide');
    $(".tr-id-"+id+"").remove();
    var tabel_toko = $('#tabel_toko').DataTable();
        tabel_toko.draw(); 
    }

    
    });
    
    });
// end fungsi hapus data

//fungsi edit data 
    $(document).on('click', '.btn-edit', function (e) {
    
    $("#modal_edit").modal('show');
    var nama_toko = $(this).attr("data-toko"); 
  	var alamat_toko = $(this).attr("data-alamat");  
    var no_toko = $(this).attr("data-no");  

    var id  = $(this).attr("data-id");
    $("#nama_edit").val(nama_toko);
	  $("#alamat_edit").val(alamat_toko);
    $("#no_toko_edit").val(no_toko);
    $("#id_edit").val(id); 
    
    });
    
    $("#submit_edit").click(function(){
    var nama_toko = $("#nama_edit").val();
    var alamat_toko = $("#alamat_edit").val();
    var no_toko = $("#no_toko_edit").val();
    var id = $("#id_edit").val();

		if (nama_toko == ""){
			alert("Nama Harus Diisi");
		}
		else if (alamat_toko == ""){
			alert("Alamat Harus Diisi");
		}
    else if (no_toko == ""){
      alert("Nomor Telphone Harus Diisi");
    }
		else { 
					$.post("proses_edit_toko.php",{id:id,nama_toko:nama_toko,alamat_toko:alamat_toko,no_toko:no_toko},function(data){

			if (data != '') {
			$(".alert").show('fast');
			$("#table_baru").load('tabel-toko.php');
			
			setTimeout(tutupalert, 2000);
			$(".modal").modal("hide");
			}
          var tabel_toko = $('#tabel_toko').DataTable();
              tabel_toko.draw();
		
		});
		} 
    });
    


//end function edit data

    $('form').submit(function(){
    
    return false;
    });
    
    });
    
    
    
    
    function tutupalert() {
    $(".alert").hide("fast");

    }
    


</script>


<?php include 'footer.php'; ?>

