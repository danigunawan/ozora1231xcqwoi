<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="container">

 <h3><b>DAFTAR DATA PENJUALAN</b></h3><hr>


<div class="dropdown">
             <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Jenis Laporan <span class="caret"></span></button>

             <ul class="dropdown-menu">
				<li><a href="lap_penjualan_rekap.php"> Laporan Penjualan Rekap </a></li> 
				<li><a href="lap_penjualan_detail.php"> Laporan Penjualan Detail </a></li>
				<li><a href="lap_penjualan_harian.php"> Laporan Penjualan Harian </a></li>
				<li><a href="lap_omset.php"> Laporan Omset </a></li>
				<li><a href="lap_kekuatan_jual_item.php"> Laporan Kekuatan Jual Peritem </a></li>
				<!--
				
				<li><a href="lap_pelanggan_rekap.php"> Laporan Jual Per Pelanggan Rekap </a></li>
				<li><a href="lap_sales_detail.php"> Laporan Jual Per Sales Detail </a></li>
				<li><a href="lap_sales_rekap.php"> Laporan Jual Per Sales Rekap </a></li>
				-->

             </ul>
</div> <!--/ dropdown-->


<br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="table_lap_penjualan" class="table table-bordered table-sm">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Marketplace</th>
			<th style="background-color: #4CAF50; color: white;"> Toko</th>
			<th style="background-color: #4CAF50; color: white;"> Konsumen</th>
			<th style="background-color: #4CAF50; color: white;"> Total Kotor </th>
			<th style="background-color: #4CAF50; color: white;"> Total Bersih </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> Petugas </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>
			<th style="background-color: #4CAF50; color: white;"> Kembalian </th>
						
		</thead>
		
	

	</table>
</span>
</div> <!--/ responsive-->
<a href='download_lap_penjualan.php' type='submit' target="blank" id="btn-download" class='btn btn-purple'><i class="fa fa-download"> </i> Download Excel</a>

</div> <!--/ container-->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
          var dataTable = $('#table_lap_penjualan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_penjualan.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[11]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->

<?php include 'footer.php'; ?>