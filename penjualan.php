<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$status = $_GET['status'];

 ?>




<div class="container"><!--start of container-->


<!-- Modal input_resi -->
<div id="modal_resi" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Input Resi </h4>
      </div>
      <div class="modal-body">
  <form enctype="multipart/form-data" role="form"  method="post ">
    <div class="form-group">
              <label class="gg" > Nomor Resi </label><br>
        <input type="text" style="height:20px" name="nomor_resi" id="nomor_resi" class="form-control" placeholder="Nomor Resi">
    </div>


       <div class="form-group">
          <label class="gg" > Ekspedisi </label><br>
          
          <select name="ekspedisi" id="ekspedisi"  class="form-control chosen" required="" autofocus="" >
          <?php 
          
      
          $query_ekspedisi = $db->query("SELECT id,nama_ekspedisi FROM ekspedisi ");
          

          while($data_expedisi = mysqli_fetch_array($query_ekspedisi))
          {
           echo "<option selected value='".$data_expedisi['id'] ."'>".$data_expedisi['nama_ekspedisi'] ."</option>"; 
          }
          ?>
          </select>
      </div>

     <input type="hidden" class="form-control" id="id_penjualan" name="id_penjualan">
    <button type="submit" id="submit_resi" class="btn btn-primary">Submit</button>
  </form>
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal input resi -->



<!-- Modal lihat_resi -->
<div id="modal_lihat_resi" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <marquee>Lihat Resi</marquee> </h4> 
      </div>
      <div class="modal-body">
  <form enctype="multipart/form-data" role="form"  method="post ">
    <div class="form-group">
              <label class="gg" ><h4><i>Nomor Resi</i></h4> </label>
        <input type="text" name="lihat_nomor_resi" style="font-size:30px" id="lihat_nomor_resi" class="form-control" placeholder="Nomor Resi" readonly="">
    </div>


       <div class="form-group">
          <label class="gg" > <h4><i>Ekspedisi</i></h4> </label>
          <input type="text" name="lihat_ekspedisi" style="font-size:30px" id="lihat_ekspedisi"  class="form-control" readonly="" >
      </div>

        <select name="ganti_ekspedisi" id="ganti_ekspedisi"  style="display:none;" class="form-control chosen" >
          <?php 
          
      
          $query_ekspedisi = $db->query("SELECT id,nama_ekspedisi FROM ekspedisi ");
          

          while($data_expedisi = mysqli_fetch_array($query_ekspedisi))
          {
           echo "<option selected value='".$data_expedisi['id'] ."'>".$data_expedisi['nama_ekspedisi'] ."</option>"; 
          }
          ?>
          </select>

      <input type="hidden" name="id_resi" id="id_resi" >
  </form>
        <i><p style="color:red;"> <b>**Note : klik dua kali untuk mengubah data </b></i>

      </div>      

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal lihat resi -->



<script type="text/javascript"> 
             $("#lihat_nomor_resi").dblclick(function(){


                  $("#lihat_nomor_resi").attr("readonly",false);

                });

                $("#lihat_nomor_resi").blur(function(){

                  var id = $("#id_resi").val();

                  var input_nomor_resi_baru = $("#lihat_nomor_resi").val();


                  $.post("update_resi.php",{id:id,input_nomor_resi_baru:input_nomor_resi_baru,jenis_edit:"nomor_resi"},function(data){

                  $("#lihat_nomor_resi").attr("readonly",true);
                  
                   var table_penjualan = $('#table_penjualan').DataTable();
                    table_penjualan.draw();


             });
     });
</script>

<script type="text/javascript">
    $("#lihat_ekspedisi").dblclick(function(){


                  $("#lihat_ekspedisi").attr("type","hidden");
                  $("#ganti_ekspedisi").show();
                });

                $("#ganti_ekspedisi").change(function(){

                  var id = $("#id_resi").val();

                  var input_nama_expedisi = $(this).val();


                  $.post("update_resi.php",{id:id,input_nama_expedisi:input_nama_expedisi,jenis_edit:"nama_expedisi"},function(data){

                  $("#lihat_ekspedisi").attr("type","text");
                  $("#lihat_ekspedisi").val(data);
                  $("#ganti_ekspedisi").hide();
                  console.log(data);
                   
                   var table_penjualan = $('#table_penjualan').DataTable();
                   table_penjualan.draw();


             });
     });
</script>



<script type="text/javascript">
// tampil modal lihat resi
  $(document).ready(function(){
    $(document).on('click','.lihat_resi',function(e){

      var nama_ekspedisi = $(this).attr('nama_ekspedisi');
      var nomor_resi = $(this).attr('nomor_resi');
      var id_resi = $(this).attr('id_penjualan');
      
      $("#lihat_nomor_resi").val(nomor_resi);
      $("#lihat_ekspedisi").val(nama_ekspedisi);
      $("#id_resi").val(id_resi);
      $("#modal_lihat_resi").modal('show');
      $("#lihat_ekspedisi").show();
      $("#lihat_ekspedisi").attr("type","text");
      $("#ganti_ekspedisi").hide();
      $("#lihat_nomor_resi").attr("readonly",true);
  });
  });
</script>


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Penjualan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label>Kode Marketplace :</label>
     <input type="text" id="kode_pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
     <input type="hidden" id="kode_meja" class="form-control" > 
     <input type="hidden" id="faktur_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Penjualan</h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

        <div class="table-responsive"> 
          <table id="table_detail_penjualan" class="table table-bordered">
          <thead>
          <th> Nomor Faktur </th>
          <th> Kode Barang </th>
          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Satuan </th>
          <th> Harga </th>
          <th> Subtotal </th>
          <th> Potongan </th>
          <th> Tax </th>
      <?php 
             if ($_SESSION['otoritas'] == 'Pimpinan')
             {
             
             
             echo "<th> Hpp </th>";
             }
      ?>

          
          <th> Sisa Barang </th>
          
          
          </thead>
          </table>
        </div>
     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert">
       </span>
      </div>

     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Piutang atau Item Keluar</h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<h3>DATA PENJUALAN</h3>
<hr>

<div class="row">

<div class="col-sm-5">

<?php 
include 'db.php';

$pilih_akses_penjualan_tambah = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_tambah = '1'");
$penjualan_tambah = mysqli_num_rows($pilih_akses_penjualan_tambah);


if ($penjualan_tambah > 0){
 echo '<a href="formpenjualan.php" class="btn btn-info" > <i class="fa fa-plus"> </i>  PENJUALAN </a>';
 
}
?>

</div>

<input type="hidden" name="status" id="status" value="<?php echo $status; ?>">
<div class="col-sm-7">
	<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
       <?php if ($status == 'semua'): ?>

      <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=semua'> Semua Penjualan </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Lunas' > Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Piutang' > Penjualan Piutang </a></li>
       	
       <?php endif ?>

       <?php if ($status == 'Lunas'): ?>

         <li class="nav-item"><a class="nav-link" href='penjualan.php?status=semua'> Semua  Penjualan </a></li>
        <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=Lunas'> Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Piutang' > Penjualan Piutang </a></li>
       	
       <?php endif ?>

       <?php if ($status == 'Piutang'): ?>

          <li class="nav-item"><a class="nav-link" href='penjualan.php?status=semua'> Semua  Penjualan </a></li>
        <li class="nav-item"><a class="nav-link" href='penjualan.php?status=Lunas'> Penjualan Lunas </a></li>
        <li class="nav-item"><a class="nav-link active" href='penjualan.php?status=Piutang'> Penjualan Piutang </a></li>
       	
       <?php endif ?>


         </ul>
</div>
       
</div>



<style>


tr:nth-child(even){background-color: #f2f2f2}


</style>
<br>



<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="table_penjualan" class="table table-bordered table-sm">
		<thead>

		
			
<?php 
include 'db.php';

$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){
				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
			}
				
?>



<?php 
include 'db.php';

$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


    if ($penjualan_hapus > 0){

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";

		}
?>
			<th style='background-color: #4CAF50; color:white'> Cetak  Tunai </th>
			<th style='background-color: #4CAF50; color:white'> Cetak Piutang </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>
      <th style='background-color: #4CAF50; color:white'> Resi Penjualan </th>      
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th> 
      <th style='background-color: #4CAF50; color:white'> Invoice Marketplace</th>
      <th style='background-color: #4CAF50; color:white'> Toko </th> 
			<th style='background-color: #4CAF50; color:white'> Marketplace</th>
      <th style='background-color: #4CAF50; color:white'> Nama Konsumen </th>
      <th style='background-color: #4CAF50; color:white'> Alamat Konsumen </th>
      <th style='background-color: #4CAF50; color:white'> Nomor Telpon Konsumen </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Jt </th>
			<th style='background-color: #4CAF50; color:white'> Petugas Kasir </th>
			<th style='background-color: #4CAF50; color:white'> Sales </th>
			<th style='background-color: #4CAF50; color:white'> Status </th>
			<th style='background-color: #4CAF50; color:white'> Potongan </th>
			<th style='background-color: #4CAF50; color:white'> Tax </th>
      <th style='background-color: #4CAF50; color:white'> Tunai </th>
			<th style='background-color: #4CAF50; color:white'> Kembalian </th>
			<th style='background-color: #4CAF50; color:white'> Kredit </th>
			
			

			
		</thead>
		
		<tbody>
		</tbody>

	</table>
</span>
</div>



</div><!--end of container-->
		



  <script type="text/javascript">
  // ajax table penjualan
  $(document).ready(function(){
    $(document).ready(function(){

      var status = $('#status').val();

        $("#table_penjualan").DataTable().destroy();
          var dataTable = $('#table_penjualan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_penjualan.php", // json datasource
            "data": function ( d ) {
                  d.status = status;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          }

      }); 
  });
  });
</script>

<script type="text/javascript">
// table ajax untuk detail penjualan
  $(document).ready(function(){
    $(document).on('click','.detail',function(e){

      var no_faktur = $(this).attr('no_faktur');

    $("#modal_detail").modal('show');
    $("#table_detail_penjualan").DataTable().destroy();
          var dataTable = $('#table_detail_penjualan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_detail_penjualan.php", // json datasource
            "data": function ( d ) {
                  d.no_faktur = no_faktur;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_detail_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          }

      }); 
  });
  });
</script>



<script type="text/javascript">
// tampil modal input resi
  $(document).ready(function(){
    $(document).on('click','.input_resi',function(e){

      var id_penjualan = $(this).attr('id_penjualan');

      $("#id_penjualan").val(id_penjualan);
      $("#modal_resi").modal('show');
    
  });
  });
</script>



    <script type="text/javascript">
    //proses input resi
        $("#submit_resi").click(function(){

        var nomor_resi = $("#nomor_resi").val();
        var ekspedisi = $("#ekspedisi").val();
        var id_penjualan = $("#id_penjualan").val();
        

        $.post('proses_input_resi.php',{nomor_resi:nomor_resi, ekspedisi:ekspedisi,id_penjualan:id_penjualan},function(data){

        $("#nomor_resi").val('');
        $("#modal_resi").modal('hide');
       var table_penjualan = $('#table_penjualan').DataTable();
            table_penjualan.draw();

      });
      });
    //proses input resi
    </script>






		<script type="text/javascript">
			$(document).ready(function(){
//fungsi hapus data

		$(document).on('click', '.btn-hapus', function (e) {
		var kode_pelanggan = $(this).attr("data-pelanggan");
		var id = $(this).attr("data-id");
		var no_faktur = $(this).attr("data-faktur");
		var kode_meja = $(this).attr("kode_meja");
		$("#kode_pelanggan").val(kode_pelanggan);
		$("#faktur_hapus").val(no_faktur);
		$("#kode_meja").val(kode_meja);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		
		var id = $(this).attr("data-id");
		var no_faktur = $("#faktur_hapus").val();
		var kode_meja = $("#kode_meja").val();
		
		

		$.post("hapus_data_penjualan.php",{id:id,no_faktur:no_faktur,kode_meja:kode_meja},function(data){
    
    $("#modal_hapus").modal('hide');
    $('#table_penjualan').DataTable().destroy();
            var dataTable = $('#table_penjualan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ordering": false,
          "ajax":{
            url :"datatable_penjualan.php", // json datasource
               "data": function ( d ) {
                  d.status = $("#status").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",   // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_penjualan").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_penjualan_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[21]+'');
            },

        } );

		});
		});

		$('form').submit(function(){
				return false;
		});
});

		</script>

		<script type="text/javascript">
		
		$(".pindah_meja").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		var kode_meja = $(this).attr('kode_meja');
		$("#no_faktur_meja").val(no_faktur);
		$("#meja_lama").val(kode_meja);
		$("#modal_meja_edit").modal('show');
		});

		$("#submit_meja").click(function(){
		var no_faktur = $("#no_faktur_meja").val();
		var kode_meja = $("#meja_lama").val();
		var meja_baru = $("#meja_edit").val();
		
		$.post('proses_pindah_meja.php',{no_faktur:no_faktur,kode_meja:kode_meja,meja_baru:meja_baru},function(info) {
		
		$(".alert").show();
		$("#table-baru").html(info);
		$("#table-baru").load('tabel-penjualan.php');
		setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
		
		
		});
		
		});
		
				$('form').submit(function(){
				
				return false;
				});


     function tutupmodal() {
     $("#modal_meja_edit").modal("hide")
     }
     function tutupalert() {
     $(".alert").hide("fast")
     }
		</script>




		<script type="text/javascript">
			
		$(".void").click(function(){

		var no_faktur = $(this).attr('no_faktur');

		$("#no_faktur_batal").val(no_faktur);
		$("#modal_void").modal('show');

		});

$("#login").click(function(){

		var username = $("#username").val();
		var password = $("#password").val();

		$.post('proses_login_void.php',{username:username,password:password},function(data){

	if (data == "sukses") {

		
		$("#modal_void").modal('show');
		$("#modal_login").hide('fast');
		$("#modal_keterangan").show('fast');
		$(".alert-sukses").show();
		$(".alert-void").hide();
		setTimeout(tutupalert, 2000);

		}
		else{

		$("#modal_login").hide('fast');

			$(".alert-void").show();
			setTimeout(tutupalert, 2000);

			$("#username").val('');
			$("#password").val('');
		$("#modal_login").show('fast');
		}

		





});

		

});


     function tutupmodal() {
     $("#modal_void").modal("hide")
     }
     function tutupalert() {
     $(".alert-sukses").hide("fast")
     $(".alert-void").hide("fast")
     }

		</script>

		<script type="text/javascript">



			$("#batal_penjualan").click(function(){

				var keterangan = $("#keterangan").val();
				var no_faktur = $("#no_faktur_batal").val();
				

				$.post('proses_batal_void.php',{keterangan:keterangan, no_faktur:no_faktur},function(data){

				$("#table-baru").load('tabel-penjualan.php');
				$("#keterangan").val('');
				$("#modal_void").modal('hide');

			});
			});
		</script>


<script type="text/javascript">
	
		$(document).on('click', '.btn-alert', function (e) {
		var no_faktur = $(this).attr("data-faktur");

		$.post('modal_retur_piutang.php',{no_faktur:no_faktur},function(data){


		$("#modal_alert").modal('show');
		$("#modal-alert").html(data);

		});

		
		});

</script>

<!--/Pagination teal-->

<?php 
include 'footer.php';
 ?>