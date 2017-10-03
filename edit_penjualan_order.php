<?php include_once 'session_login.php';
   
  // memasukan file session login,  header, navbar, db.php,
  include 'header.php';
  include 'navbar.php';
  include 'db.php';
  include 'sanitasi.php';


  $pilih_akses_tombol = $db->query("SELECT * FROM otoritas_form_order_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
  $otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

  // menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB
  $no_faktur = stringdoang($_GET['no_faktur']);
  $kode_pelanggan = stringdoang($_GET['kode_pelanggan']);
  $nama_pelanggan = stringdoang($_GET['nama_pelanggan']);
  $id_toko = stringdoang($_GET['id_toko']);
  $nama_toko = stringdoang($_GET['nama_toko']);


  $ambil_pelanggan = $db->query("SELECT level_harga FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
  $out_pelanggan = mysqli_fetch_array($ambil_pelanggan);
  $level_harga = $out_pelanggan['level_harga'];

  $ambil_penjualan = $db->query("SELECT sales, tanggal, nama_konsumen, alamat_konsumen,invoice_marketplace,no_telpon_konsumen, keterangan FROM penjualan_order WHERE no_faktur_order = '$no_faktur'");
  $data_penjualan = mysqli_fetch_array($ambil_penjualan);


  $session_id = session_id();

   ?>

  <!-- Modal Untuk Confirm PESAN alert-->
  <div id="modal_promo_alert" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
      <div class="modal-header">

    
          <button type="button" class="close" data-dismiss="modal">&times;</button>       
      </div>
      <div class="modal-body">
        <span id="tampil_alert">
        </span>
      </div>
      <div class="modal-footer">
          
          <button type="button" class="btn btn-danger" data-dismiss="modal">Closed</button>
      </div>
      </div>
    </div>
  </div>
  <!--modal end pesan alert-->


  <!-- js untuk tombol shortcut -->
   <script src="shortcut.js"></script>
  <!-- js untuk tombol shortcut -->


   <style type="text/css">
    .disabled {
      opacity: 0.6;
      cursor: not-allowed;
      disabled: true;
  }
  </style>


  <script>
    $(function() {
      $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

<div style="padding-left: 5%; padding-right: 2%">
    <h3>EDIT ORDER PENJUALAN : <?php echo $no_faktur; ?> </h3>
  <div class="row">

  <div class="col-sm-8">


   <!-- membuat form menjadi beberpa bagian -->
    <form enctype="multipart/form-data" role="form" action="form_order_penjualan.php" method="post ">
          
    <!--membuat teks dengan ukuran h3-->
    <div class="form-group">
          <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">
          <input type="hidden" style="font-size:15px; height:15px" id="no_faktur_order" name="no_faktur_order" class="form-control" value="<?php echo $no_faktur;?>" required="">  
    </div>


  <div class="row">

    <div class="col-sm-3">
      <label> Marketplace </label><br>
        <select name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="" autofocus="">

          <?php
            $query = $db->query("SELECT * FROM pelanggan");
            while($data = mysqli_fetch_array($query)){
              if ($kode_pelanggan == $data['kode_pelanggan']) {
                echo "<option selected value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";
              }
              else{
                echo "<option value='".$data['kode_pelanggan'] ."' class='opt-pelanggan-".$data['kode_pelanggan']."' data-level='".$data['level_harga'] ."'>".$data['kode_pelanggan'] ." - ".$data['nama_pelanggan'] ."</option>";

              }
            }
          ?>

        </select>
    </div>

    <div class="col-sm-2">
      <label class="gg" > Nama Toko </label><br>
        <select name="nama_toko" id="nama_toko"  class="form-control chosen" required="" autofocus="" >
          <?php 
            $query_toko = $db->query("SELECT id,nama_toko FROM toko");
              while($data_toko = mysqli_fetch_array($query_toko)){
                if ($id_toko == $data_toko['id']) {
                  echo "<option selected value='".$data_toko['id'] ."'>".$data_toko['nama_toko'] ."</option>";
                }
                else{
                  echo "<option value='".$data_toko['id'] ."'>".$data_toko['nama_toko'] ."</option>";
                }
              }
          ?>
        </select>
    </div>

    <div class="col-sm-2" style="display: none">

      <label class="gg" > Gudang </label><br>
        <select style="font-size:15px; height:35px" name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
            <?php             
              $query = $db->query("SELECT * FROM gudang");
                while($data = mysqli_fetch_array($query)){
                  if ($data['default_sett'] == '1') {
                    echo "<option selected value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
                  }
                  else{
                    echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
                  }
              
              }            
            
            ?>
        </select>
    </div>

    <div class="col-sm-2">
        <label class="gg" >Admin</label>
        <select style="font-size:15px; height:35px" name="sales" id="sales" class="form-control chosen" required="">
            <?php 
              $query01 = $db->query("SELECT id,nama FROM user WHERE status_sales = 'Iya'");
                while($data01 = mysqli_fetch_array($query01)){

                  if ($data_penjualan['sales'] == $data01['id']) {
                    echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
                  }
                  else{
                    echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";                   
                  }
                }
            ?>

        </select>
    </div>

    <div class="col-sm-1">
      <label> Level Harga </label><br>
      <select style="font-size:15px; height:35px" type="text" name="level_harga" id="level_harga" class="form-control chosen" required="" >
        <option value="Level 1">WA</option>
        <option value="Level 2">Marketplace</option>
        <option value="Level 3"></option>
      </select>
    </div>    
  

    <div class="col-sm-1">
      <label class="gg">PPN</label>
        <select type="hidden" style="font-size:15px; height:35px" name="ppn" id="ppn" class="form-control chosen">
          <option value="Include">Include</option>
          <option value="Exclude">Exclude</option>
          <option value="Non">Non</option>
        </select>
    </div>

    <div class="col-sm-1">
      <label class="gg">Tanggal</label>
        <input type="text" style="font-size:15px; height:15px" value="<?php echo $data_penjualan['tanggal'];?>" name="tanggal" id="tanggal" class="form-control">
    </div>

  </div>

  </form><!--tag penutup form-->

  
  <button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button>

   
  <!--tampilan modal-->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- isi modal-->
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data Barang</h4>
        </div>
        <div class="modal-body">
        <center>
          <div class="table-responsive">
            <table id="tabel_cari" class="table table-bordered table-sm">
              <thead> <!-- untuk memberikan nama pada kolom tabel -->

                        <th> Kode Barang </th>
                        <th> Nama Barang </th>
                        <th> Harga Level 1</th>
                        <th> Harga Level 2</th>
                        <th> Harga Level 3</th>
                        <th> Jumlah Barang </th>
                        <th> Satuan </th>
                        <th> Kategori </th>
                        <th> Suplier </th>

              </thead> <!-- tag penutup tabel -->
            </table>
          </div>
        </center>
  </div> <!-- tag penutup modal-body-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div><!-- end of modal data barang  -->



  <!-- Modal Hapus data -->
  <div id="modal_hapus" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Konfirmsi Hapus Data Tbs Penjualan</h4>
        </div>
        <div class="modal-body">
     <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
     <form >
      <div class="form-group">
       <input type="text" id="nama-barang" class="form-control" readonly=""> 
       <input type="hidden" id="id_hapus" class="form-control" >
       <input type="hidden" id="kode_hapus" class="form-control" >
      </div>
     
     </form>
     
    <div class="alert alert-success" style="display:none">
     <strong>Berhasil!</strong> Data berhasil Di Hapus
    </div>
   

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
        </div>
      </div>

    </div>
  </div><!-- end of modal hapus data  -->



  <!-- membuat form prosestbspenjual -->

  <form id="form_barcode" class="form-inline">
    <br>
      <div class="form-group">
          <input type="text" style="height:15px" name="kode_barcode" id="kode_barcode" class="form-control" placeholder="Kode Barcode">
      </div>
          
      <button type="submit" id="submit_barcode" class="btn btn-primary" style="font-size:15px" ><i class="fa fa-barcode"></i> Submit Barcode</button>
          
      
          
    </form>

            <div class="alert alert-danger" id="alert_stok" style="display:none">
            <strong>Perhatian!</strong> Persediaan Barang Tidak Cukup!
            </div>

    <?php if ($otoritas_tombol['tombol_submit'] > 0):?>  

  <form class="form"  role="form" id="formtambahproduk">

  <div class="row">

    <div class="col-sm-3">

    <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
      <option value="">SILAKAN PILIH...</option>
         <?php 

          include 'cache.class.php';
            $c = new Cache();
            $c->setCache('produk');
            $data_c = $c->retrieveAll();

            foreach ($data_c as $key) {
              echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
            }

          ?>
      </select>
    </div>


      <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama" >

    <div class="col-sm-2">
      <input style="height:15px;" type="text" class="form-control" name="jumlah_barang"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" autocomplete="off" id="jumlah_barang" placeholder="Jumlah" >
    </div>

    <div class="col-sm-2">
            
            <select style="font-size:15px; height:35px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="">
            
            <?php 
            
            
            $query = $db->query("SELECT id, nama  FROM satuan");
            while($data = mysqli_fetch_array($query))
            {
            
            echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
            }
                        
            ?>
            
            </select>
    </div>


     <div class="col-sm-2">
      <input style="height:15px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan">
    </div>

     <div class="col-sm-1">
      <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
    </div>


    <button type="submit" id="submit_produk" class="btn btn-success" style="font-size:15px"><i class="fa fa-plus"></i> Submit (F3)</button>

  </div>

    <input type="hidden" class="form-control" name="limit_stok" autocomplete="off" id="limit_stok" placeholder="Limit Stok" >
      <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >
      <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">
      <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">
      <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
      <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
      <input type="text" id="harga_produk" name="harga" class="form-control" value="" required="">
      <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">        

  </form> <!-- tag penutup form -->

  <?php endif ?>

                  <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                  <span id='tes'></span>            
                  
                  <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                  <table id="tabel_tbs_editorder" class="table table-sm">
                  <thead>
                  <th> Kode  </th>
                  <th style="width:1000%"> Nama </th>
                  <th> Jumlah </th>
                  <th> Satuan </th>
                  <th> Harga </th>
                  <th> Potongan </th>
                  <th> Pajak </th>
                  <th> Subtotal </th>
                  <th> Hapus </th>
                  
                  </thead>
                  
                  </table>
                  </span>
                  </div>
                  <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                  <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>


  </div> <!-- / END COL SM 6 (1)-->


  <div class="col-sm-4">

  <form action="proses_bayar_jual.php" id="form_jual" method="POST" >
      
      <style type="text/css">
      .disabled {
      opacity: 0.6;
      cursor: not-allowed;
      disabled: false;
      }
      </style>

    <div class="form-group">
      <div class="card card-block">
        
        <div class="col-sm-12">
          <label style="font-size:15px"> <b> Subtotal </b></label><br>
          <input style="height:30px;font-size:30px" type="text" name="total" id="total2" class="form-control" placeholder="Subtotal" readonly="" >
        </div>
          
        <div class="col-sm-6">
          <label style="font-size:15px"> <b> Invoice Marketplace </b></label><br>
          <input type="text" style="height:20px" name="invoice_marketplace" id="invoice_marketplace" value="<?php echo $data_penjualan['invoice_marketplace'] ?>" class="form-control" placeholder="Invoice Marketplace">
        </div>

        <div class="col-sm-6">
          <label style="font-size:15px"> <b> Nama Konsumen </b></label><br>
          <input type="text" style="height:20px" name="nama_konsumen" id="nama_konsumen" class="form-control" value="<?php echo $data_penjualan['nama_konsumen'] ?>" placeholder="Nama Konsumen">
        </div>

        <div class="col-sm-6">
          <label style="font-size:15px"> <b> No Telpon Konsumen </b></label><br>
          <input type="text" style="height:20px" name="no_telpon_konsumen" id="no_telpon_konsumen" value="<?php echo $data_penjualan['no_telpon_konsumen'] ?>" class="form-control" placeholder="Nomor Telpon Konsumen">
        </div>

        <div class="col-sm-6">
          <label style="font-size:15px"> <b> Alamat Konsumen </b></label><br>
          <input type="text" style="height:20px" name="alamat_konsumen" id="alamat_konsumen" class="form-control" value="<?php echo $data_penjualan['alamat_konsumen'] ?>" placeholder="Alamat Konsumen">
        </div>

        <div class="col-sm-12">
          <label style="font-size:15px"> <b> Keterangan </b></label><br>
          <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control">
            <?php echo $data_penjualan['keterangan'] ?>
          </textarea>
        </div>

      </div>
    </div>

      <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">
      <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
      <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
          
      <?php if ($otoritas_tombol['tombol_order'] > 0):?>
        <button type="submit" id="order" class="btn btn-primary" style="font-size:15px"><i class="fa fa-send"></i> Order (F10)</button>      
      <?php endif; ?>

      <a href='cetak_penjualan_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Order  </a>
      <button type="button" class="btn btn-info" id="transaksi_baru" style="display: none">  Transaksi Baru </a>
      <button type="submit" id="cetak_langsung" target="blank"  style="display: none;" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button><br>

      <div class="alert alert-success" id="alert_berhasil" style="display:none">
        <strong>Success!</strong> Pembayaran Berhasil
      </div>

    </form>

    </div> <!-- div col sm 4-->
  </div><!-- / END row atas-->


  </div><!-- end of container -->


   <script>
      $(function() {
      $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>


  <script type="text/javascript">
   (function(seconds) {
      var refresh,       
          intvrefresh = function() {
              clearInterval(refresh);
              refresh = setTimeout(function() {
                 location.href ="order_penjualan.php";
              }, seconds * 1000);
          };

      $(document).on('keypress click', function() { intvrefresh() });
      intvrefresh();

  }(300)); // define here seconds

  </script>


  <script type="text/javascript">
    $(document).on('click', '.tidak_punya_otoritas', function (e) {
      alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk !!");
    });
  </script>
      


  <script type="text/javascript">
    $(document).ready(function() {
      var dataTable = $('#tabel_tbs_editorder').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax":{
          url :"data_tbs_edit_order_penjualan.php", // json datasource
          "data": function ( d ) {
            d.no_faktur_order = $("#no_faktur_order").val();
            // d.custom = $('#myInput').val();
            // etc
          },
           
           type: "post",  // method  , by default get
           error: function(){  // error handling
             $(".employee-grid-error").html("");
             $("#tabel_tbs_editorder").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
             $("#employee-grid_processing").css("display","none");
             }
        },
          "fnCreatedRow": function( nRow, aData, iDataIndex ) {
             $(nRow).attr('class','tr-id-'+aData[9]+'');
           }
      });
    });
  </script>
      
  <script>
  //untuk menampilkan data tabel
  $(document).ready(function(){
      $("#kode_barang").trigger("chosen:open");

  });

  </script>

  <!--Start Ajax Modal Cari-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_produk_order_penjualan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");

            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('harga_level_2', aData[3]);
              $(nRow).attr('harga_level_3', aData[4]);
              $(nRow).attr('jumlah-barang', aData[5]);
              $(nRow).attr('satuan', aData[12]);
              $(nRow).attr('kategori', aData[7]);
              $(nRow).attr('status', aData[11]);
              $(nRow).attr('suplier', aData[8]);
              $(nRow).attr('limit_stok', aData[9]);
              $(nRow).attr('ber-stok', aData[10]);
              $(nRow).attr('id-barang', aData[13]);

          }

        });

  });
 </script>
  <!--Start Ajax Modal Cari-->


  <!--untuk memasukkan perintah java script-->
  <script type="text/javascript">

  // jika dipilih, nim akan masuk ke input dan modal di tutup
    $(document).on('click', '.pilih', function (e) {


      document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger("chosen:updated");
  $("#kode_barang").trigger("chosen:open");

  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id-barang');



var level_harga = $("#level_harga").val();

var harga_level_1 = $(this).attr('harga');
var harga_level_2 = $(this).attr('harga_level_2');
var harga_level_3 = $(this).attr('harga_level_3');

if (level_harga == "Level 1") {
  $("#harga_produk").val(harga_level_1);
  $("#harga_lama").val(harga_level_1);
  $("#harga_baru").val(harga_level_1);
}

else if (level_harga == "Level 2") {
  $("#harga_produk").val(harga_level_2);
  $("#harga_baru").val(harga_level_2);
  $("#harga_lama").val(harga_level_2);
}

else if (level_harga == "Level 3") {
  $("#harga_produk").val(harga_level_3);
  $("#harga_lama").val(harga_level_3);
  $("#harga_baru").val(harga_level_3);
}

    document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');


  $.post("lihat_promo_alert.php",{id:$(this).attr('id-barang')},function(data){

      if (data == '')
      {

      }
      else{
        $("#modal_promo_alert").modal('show');
        $("#tampil_alert").html(data);
      }

  });



    $('#myModal').modal('hide'); 
    $("#jumlah_barang").focus();


  });

    </script>


  <script type="text/javascript">
  $(document).ready(function(){
    //end cek level harga
    $("#level_harga").change(function(){
    
    var level_harga = $("#level_harga").val();
    var kode_barang = $("#kode_barang").val();
    var satuan_konversi = $("#satuan_konversi").val();
    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var id_produk = $("#id_produk").val();

  if (kode_barang != '')
  {
    $.post("cek_level_harga_barang.php",
          {level_harga:level_harga, kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

            $("#harga_produk").val(data);
            $("#harga_baru").val(data);
          });
  }


      });
  });
  //end cek level harga
  </script>



  <!-- cek stok satuan konversi change-->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#satuan_konversi").change(function(){
        var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
        var satuan_konversi = $("#satuan_konversi").val();
        var kode_barang = $("#kode_barang").val();
        var id_produk = $("#id_produk").val();
        var prev = $("#satuan_produk").val();
        


        $.post("cek_stok_konversi_penjualan.php", {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk},function(data){

        

            if (data < 0) {
              alert("Jumlah Melebihi Stok");
              $("#jumlah_barang").val('');
            $("#satuan_konversi").val(prev);

            }

        });
      });
    });
  </script>
  <!-- end cek stok satuan konversi change-->

  <!-- cek stok satuan konversi keyup-->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#jumlah_barang").keyup(function(){
        var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
        var satuan_konversi = $("#satuan_konversi").val();
        var kode_barang = $("#kode_barang").val();
        var id_produk = $("#id_produk").val();
        var prev = $("#satuan_produk").val();

        $.post("cek_stok_konversi_penjualan.php",
          {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
          id_produk:id_produk},function(data){

            if (data < 0) {
              alert("Jumlah Melebihi Stok");
              $("#jumlah_barang").val('');
            $("#satuan_konversi").val(prev);

            }

        });
      });
    });
  </script>
  <!-- cek stok satuan konversi keyup-->


    <script type="text/javascript">
  //berfunsi untuk mencekal username ganda
   $(document).ready(function(){
    $(document).on('click', '.pilih', function (e) {
      var no_faktur_order = $("#no_faktur_order").val();
      var kode_barang = $("#kode_barang").val();
   $.post('cek_kode_barang_edit_tbs_penjualan_order.php',{kode_barang:kode_barang,no_faktur_order:no_faktur_order}, function(data){
    
    if(data == 1){
      alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
      $("#kode_barang").val('');
      $("#kode_barang").trigger('chosen:updated');
      $("#nama_barang").val('');
     }//penutup if

      });////penutup function(data)

      });//penutup click(function()
    });//penutup ready(function()
  </script>

  <script>
  $(document).ready(function(){
      $("#satuan_konversi").change(function(){

        var prev = $("#satuan_produk").val();
        var harga_lama = $("#harga_lama").val();
        var satuan_konversi = $("#satuan_konversi").val();
        var id_produk = $("#id_produk").val();
        var harga_produk = $("#harga_lama").val();
        var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
        var kode_barang = $("#kode_barang").val();

        

        $.getJSON("cek_konversi_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi,id_produk:id_produk,harga_produk:harga_produk,jumlah_barang:jumlah_barang},function(info){



          if (satuan_konversi == prev) {

            $("#harga_produk").val(harga_lama);
            $("#harga_baru").val(harga_lama);

          }

          else if (info.jumlah_total == 0) {
            alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
            $("#satuan_konversi").val(prev);
            $("#harga_produk").val(harga_lama);
            $("#harga_baru").val(harga_lama);

          }

          else{
   
            $("#harga_produk").val(info.harga_pokok);
            $("#harga_baru").val(info.harga_pokok);
          }

        });

          
      });

  });
  </script>


  <script type="text/javascript">
    $(document).on('click', '.tidak_punya_otoritas', function (e) {
      alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk !!");
    });
  </script>

  <script type="text/javascript">
    $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#kode_barcode").blur(function(){
        var kode_barang = $("#kode_barcode").val();

        $.post("nama_barcode.php",{kode_barang: kode_barang}, function(data){
            $("#ber_stok").val(data);
          });
        });
    });
  </script>

  <script>
    $(document).on("click", "#submit_barcode", function(){

      var kode_barang = $("#kode_barcode").val();
      var level_harga = $("#level_harga").val();
      var sales = $("#sales").val();
      var no_faktur = $("#no_faktur_order").val();

      $("#jumlah_barang").val('');
      $("#kode_barcode").val('');
      $("#potongan1").val('');
      $("#tax1").val('');

      $.get("cek_barang.php",{kode_barang:kode_barang},function(data){
        if (data != 1) {
          alert("Barang Yang Anda Pesan Tidak Tersedia !!")
        }
        else{
          $("#kode_barcode").focus();
          $.post("barcode_edit_order.php",{kode_barang:kode_barang,sales:sales,level_harga:level_harga,no_faktur:no_faktur},function(data){

            $(".tr-kode-"+kode_barang+"").remove();
            $("#ppn").attr("disabled", true);
            $("#tbody").prepend(data);
            $("#kode_barang").val('');
            $("#nama_barang").val('');
            $("#jumlah_barang").val('');
            $("#potongan1").val('');
            $("#tax1").val('');

            var no_faktur = $("#no_faktur_order").val();

            $.post("cek_edit_total_seluruh_order.php",{no_faktur:no_faktur},function(data){
              $("#total2").val(data);
            });

            var tabel_tbs_editorder = $('#tabel_tbs_editorder').DataTable();
                tabel_tbs_editorder.draw();
       
          });

          $.getJSON('lihat_nama_barang.php',{kode_barang:kode_barang}, function(json){
            $.post("lihat_promo_alert.php",{id:json.id},function(info){
              if (info == ''){
              }
              else{
                $("#modal_promo_alert").modal('show');
                $("#tampil_alert").html(info);
              }
            });
          });

        }

      });

    });

    $("#form_barcode").submit(function(){
      return false;
    });

  </script>  

  <script>
      $(document).on("click", "#submit_produk", function(){

        var no_faktur = $("#no_faktur_order").val();
        var kode_pelanggan = $("#kd_pelanggan").val();
        var kode_barang = $("#kode_barang").val();
        var nama_barang = $("#nama_barang").val();
        var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
        var level_harga = $("#level_harga").val();
        var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
        var potongan = $("#potongan1").val();
        var sub_tbs = parseInt(jumlah_barang, 10) *  parseInt(harga, 10);
          
          if (potongan == ''){
            potongan = 0;
          }
          else{
           var pos = potongan.search("%");
             if (pos > 0) 
              {
                 var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
                     potongan_persen = potongan_persen.replace("%","");
                 var potongan = parseInt(sub_tbs) * parseInt(potongan_persen) / 100 ;
              }
              else{
                var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
              }
          }

        var tax = $("#tax1").val();
        var jumlahbarang = $("#jumlahbarang").val();
        var satuan = $("#satuan_konversi").val();
        var sales = $("#sales").val();
        var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
        var ber_stok = $("#ber_stok").val();
        var ppn = $("#ppn").val();
        var stok = parseInt(jumlahbarang,10) - parseInt(jumlah_barang,10);        
        var subtotal = parseInt(jumlah_barang, 10) *  parseInt(harga, 10) - parseInt(potongan, 10);
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

          if (total == ''){
            total = 0;
          }

        var total_akhir = parseInt(total,10) + parseInt(subtotal,10);

         $("#jumlah_barang").val('');
         $("#potongan1").val('');
         $("#tax1").val('');

         if (a > 0){
            alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
         }
         else if (jumlah_barang == ''){
            alert("Jumlah Barang Harus Diisi");
            $("#jumlah_barang").focus();
         }
         else if (kode_pelanggan == ''){
            alert("Kode Pelanggan Harus Dipilih");
            $("#kd_pelanggan").focus();
         }
         else if (ber_stok == 'Jasa' ){

            $("#total2").val(tandaPemisahTitik(total_akhir));
            $.post("proses_edit_tbs_order_penjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales},function(data){    

              $("#ppn").attr("disabled", true);
              $("#tbody").prepend(data);
              $("#kode_barang").val('');
              $("#kode_barang").trigger("chosen:updated");
              $("#kode_barang").trigger("chosen:open");
              $("#nama_barang").val('');
              $("#harga_produk").val('');
              $("#ber_stok").val('');
              $("#jumlah_barang").val('');
              $("#potongan1").val('');
              $("#tax1").val('');

              var tabel_tbs_editorder = $('#tabel_tbs_editorder').DataTable();
                  tabel_tbs_editorder.draw();

            });

        }
        else if (stok < 0) {
            alert ("Jumlah Melebihi Stok Barang !");
        }
        else{
            $("#total2").val(tandaPemisahTitik(total_akhir));
            $.post("proses_edit_tbs_order_penjualan.php",{no_faktur:no_faktur,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,sales:sales},function(data){
       

             $("#ppn").attr("disabled", true);
             $("#tbody").prepend(data);             
             $("#kode_barang").val('');
             $("#kode_barang").trigger("chosen:updated");
             $("#kode_barang").trigger("chosen:open");             
             $("#nama_barang").val('');
             $("#harga_produk").val('');
             $("#ber_stok").val('');
             $("#jumlah_barang").val('');
             $("#potongan1").val('');
             $("#tax1").val('');

             var tabel_tbs_editorder = $('#tabel_tbs_editorder').DataTable();
                 tabel_tbs_editorder.draw();

       
       });

      }

  });

    $("#formtambahproduk").submit(function(){
      return false;
    });

  </script>

  <script>
    $(document).on("click", "#order", function(){

      var no_faktur = $("#no_faktur_order").val();       
      var kode_pelanggan = $("#kd_pelanggan").val();
      var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
      var tanggal = $("#tanggal").val();
      var harga = $("#harga_produk").val();
      var nama_toko = $("#nama_toko").val();
      var sales = $("#sales").val();
      var keterangan = $("#keterangan").val();   
      var ber_stok = $("#ber_stok").val();   
      var ppn_input = $("#ppn_input").val();
      var invoice_marketplace = $("#invoice_marketplace").val();
      var nama_konsumen = $("#nama_konsumen").val();
      var no_telpon_konsumen = $("#no_telpon_konsumen").val();
      var alamat_konsumen = $("#alamat_konsumen").val();
      var ppn = $("#ppn").val();


      if (kode_pelanggan == ""){
        alert("Kode Pelanggan Harus Di Isi");
      }
      else if (nama_toko == ""){
        alert(" Kode Gudang Harus Diisi ");
      }
      else if (nama_konsumen == ""){
        alert(" Nama Konsumen Harus Diisi ");
      }
      else if (invoice_marketplace == ""){
        alert(" Invoice Marketplace Harus Diisi ");
      }
      else if (no_telpon_konsumen == ""){
        alert(" Nomor Telpon Konsumen Harus Diisi ");
      }
      else if (alamat_konsumen == ""){
        alert("Silakan Isi Alamat Konsumen");
        $("#alamat_konsumen").focus();
      }
      else if (total2 ==  0 || total2 == ""){
        alert("Anda Belum Melakukan Pemesanan");
      }
      else{

        $("#batal_penjualan").hide();
        $("#order").hide();
        $("#transaksi_baru").show();

        $.post("cek_edit_subtotal_penjualan_order.php",{total2:total2,no_faktur:no_faktur},function(data) {

          if (data != "1") {

            $.post("proses_order_penjualan_edit.php",{total2:total2,no_faktur:no_faktur,no_faktur:no_faktur,kode_pelanggan:kode_pelanggan,harga:harga,sales:sales,nama_toko:nama_toko,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,tanggal:tanggal,invoice_marketplace:invoice_marketplace,nama_konsumen:nama_konsumen,no_telpon_konsumen:no_telpon_konsumen,alamat_konsumen:alamat_konsumen},function(info) {

               $("#table-baru").html(info);
               $("#cetak_tunai").attr('href', 'cetak_penjualan_order.php?no_faktur='+no_faktur+'');
               $("#alert_berhasil").show();
               

               var tabel_tbs_editorder = $('#tabel_tbs_editorder').DataTable();
                   tabel_tbs_editorder.draw();
             });
          }
          else{
            alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
              window.location.href="form_order_penjualan.php";
            }

       });

      }

        $("form").submit(function(){
          return false;
        });

    });

  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#cari_produk_penjualan").click(function(){

        var no_faktur = $("#no_faktur_order").val();
        $.post("cek_tbs_edit_penjualan_order.php",{no_faktur:no_faktur},function(data){
          if (data != "1") {
            $("#ppn").attr("disabled", false);
          }
        });
      });
    });
  </script>

  <script>

    $(document).ready(function(){

      $("#jumlah_barang").keyup(function(){
       var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
       var jumlahbarang = $("#jumlahbarang").val();
       var limit_stok = $("#limit_stok").val();
       var ber_stok = $("#ber_stok").val();
       var stok = jumlahbarang - jumlah_barang;

       if (stok < 0 ){        
         if (ber_stok == 'Jasa') {
         
         }
         else{
           alert ("Jumlah Melebihi Stok!");
           $("#jumlah_barang").val('');
         }
       }
       else if( limit_stok > stok  ){
          alert ("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
       }

      });
    })

  </script>

  <script type="text/javascript">
    
    $(document).ready(function() {

      var no_faktur = $("#no_faktur_order").val();

      $.post("cek_edit_total_seluruh_order.php",{no_faktur:no_faktur},function(data){
        $("#total2").val(data);
      });

    });
          
  </script>

  <script type="text/javascript">

    $(document).ready(function(){
      $(document).on('click','.btn-hapus-tbs',function(e){
        
        var nama_barang = $(this).attr("data-barang");
        var id = $(this).attr("data-id");
        var kode_barang = $(this).attr("data-kode-barang");
        var subtotal_tbs = $(this).attr("data-subtotal");
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

        if (total == ''){
            total = 0;
        };

        var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10);

        $("#total2").val(tandaPemisahTitik(total_akhir));

        $.post("hapustbs_penjualan_order.php",{id:id,kode_barang:kode_barang},function(data){

          $(".tr-id-"+id+"").remove();
          $("#pembayaran_penjualan").val('');

          var tabel_tbs_editorder = $('#tabel_tbs_editorder').DataTable();
              tabel_tbs_editorder.draw();

        });

      });

        $('form').submit(function(){
          return false;
        });

    });    

  </script>

  <script type="text/javascript">
  // START script untuk pilih kode barang menggunakan chosen     
    $(document).ready(function(){
    $("#kode_barang").change(function(){

      var kode_barang = $(this).val();
      var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
      var harga_jual = $('#opt-produk-'+kode_barang).attr("harga");
      var harga_jual2 = $('#opt-produk-'+kode_barang).attr('harga_jual_2');  
      var harga_jual3 = $('#opt-produk-'+kode_barang).attr('harga_jual_3');
      var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
      var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
      var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
      var status = $('#opt-produk-'+kode_barang).attr("status");
      var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
      var limit_stok = $('#opt-produk-'+kode_barang).attr("limit_stok");
      var ber_stok = $('#opt-produk-'+kode_barang).attr("ber-stok");
      var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");
      var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
      var level_harga = $("#level_harga").val();
      var no_faktur_order = $("#no_faktur_order").val();


     if (level_harga == "Level 1") {

          $('#harga_produk').val(harga_jual);
          $('#harga_baru').val(harga_jual);
          $('#harga_lama').val(harga_jual);
          }
      else if (level_harga == "Level 2") {

          $('#harga_produk').val(harga_jual2);
          $('#harga_baru').val(harga_jual2);
          $('#harga_lama').val(harga_jual2);
          }
      else if (level_harga == "Level 3") {

          $('#harga_produk').val(harga_jual3);
          $('#harga_baru').val(harga_jual3);
          $('#harga_lama').val(harga_jual3);
          }

      $("#kode_barang").val(kode_barang);
      $("#nama_barang").val(nama_barang);
      $("#jumlah_barang").val(jumlah_barang);
      $("#satuan_produk").val(satuan);
      $("#satuan_konversi").val(satuan);
      $("#limit_stok").val(limit_stok);
      $("#ber_stok").val(ber_stok);
      $("#id_produk").val(id_barang);

  if (ber_stok == 'Barang') {

      $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
        if (data == "") {
          data = 0;
        }
        $("#jumlahbarang").val(data);
        $('#kolom_cek_harga').val('1');
      });

  }


  $.post('cek_kode_barang_edit_tbs_penjualan_order.php',{kode_barang:kode_barang,no_faktur_order:no_faktur_order}, function(data){
            
    if(data == 1){
            alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

            $("#kode_barang").chosen("destroy");
            $("#kode_barang").val('');
            $("#nama_barang").val('');
            $("#kode_barang").trigger('chosen:open');
            $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
     }//penutup if     



    });

      

    });
    }); 
    // end script untuk pilih kode barang menggunakan chosen   
  </script>


  <script>
  /* Membuat Tombol Shortcut */

  function myFunction(event) {
      var x = event.which || event.keyCode;

      if(x == 112){


       $("#myModal").modal();

      }

      else if(x == 113){


       $("#pembayaran_penjualan").focus();

      }

     else if(x == 115){


       $("#penjualan").focus();

      }
    }
  </script>

  <script type="text/javascript">
            $(document).ready(function(){
            var no_faktur = $("#no_faktur_order").val();
          
          $.post("cek_edit_total_seluruh_order.php",{no_faktur:no_faktur},
          function(data){
          $("#total2").val(data);

          });

        });


</script>

<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){
        window.location.href="order_penjualan.php";
    });
  });

</script>

<script type="text/javascript">

  $(document).ready(function(){

      $("#kd_pelanggan").change(function(){
          var kode_pelanggan = $("#kd_pelanggan").val();
          
          var level_harga = $(".opt-pelanggan-"+kode_pelanggan+"").attr("data-level");
          
          

          
          if(kode_pelanggan == 'Umum')
          {
             $("#level_harga").val('Level 1');
          }
          else 
          {
             $("#level_harga").val(level_harga);
          
          }
          
          
      });
  });

            
          </script>


  <script type="text/javascript">

    $(document).on('dblclick','.edit-jumlah',function(e){
      var id = $(this).attr("data-id");

      $("#text-jumlah-"+id+"").hide();
      $("#input-jumlah-"+id+"").attr("type", "text");
    });

    $(document).on('blur','.input_jumlah',function(e){
      
      var id = $(this).attr("data-id");
      var jumlah_baru = $(this).val();
      var kode_barang = $(this).attr("data-kode");
      var harga = $(this).attr("data-harga");
      var jumlah_lama = $("#text-jumlah-"+id+"").text();
      var satuan_konversi = $(this).attr("data-satuan");
      var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));                                     
      var subtotal = harga * jumlah_baru - potongan;
      var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
          subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

      var tax_tbs = tax / subtotal_lama * 100;
      var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;


      $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){

        if (data < 0) {
          alert ("Jumlah Yang Di Masukan Melebihi Stok !");
          $("#input-jumlah-"+id+"").val(jumlah_lama);
          $("#text-jumlah-"+id+"").text(jumlah_lama);
          $("#text-jumlah-"+id+"").show();
          $("#input-jumlah-"+id+"").attr("type", "hidden");
        }
        else{
          $("#text-jumlah-"+id+"").show();
          $("#text-jumlah-"+id+"").text(jumlah_baru);
          $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
          $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
          $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
          $("#input-jumlah-"+id+"").attr("type", "hidden"); 
          $("#total2").val(tandaPemisahTitik(subtotal_penjualan));

          $.post("update_pesanan_barang_order.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){

          });
        }

      });

        $("#kode_barang").trigger("chosen:open");

    });

  </script>

  <script type="text/javascript">
    $(document).ready(function(){

      $("#tax").attr("disabled", true);
      $("#ppn").change(function(){

      var ppn = $("#ppn").val();
      $("#ppn_input").val(ppn);

    if (ppn == "Include"){

        $("#tax").attr("disabled", true);
        $("#tax1").attr("disabled", false);
    }

    else if (ppn == "Exclude") {
      $("#tax1").attr("disabled", true);
        $("#tax").attr("disabled", false);
    }
    else{

      $("#tax1").attr("disabled", true);
        $("#tax").attr("disabled", true);
    }


    });
    });
  </script>

  <script type="text/javascript">
  $(document).ready(function(){
    $("#batal_penjualan").click(function(){
      var no_faktur = $("#no_faktur_order").val()
          window.location.href="batal_editpenjualanorder.php?no_faktur="+no_faktur+"";

    })
    });
  </script>

  <!-- SHORTCUT -->

  <script> 
      shortcut.add("f2", function() {
          // Do something

          $("#kode_barang").trigger("chosen:open");

      });

      
      shortcut.add("f1", function() {
          // Do something

          $("#cari_produk_penjualan").click();

      }); 

      
      shortcut.add("f3", function() {
          // Do something

          $("#submit_produk").click();

      }); 

      
      shortcut.add("f4", function() {
          // Do something

          $("#carabayar1").focus();

      }); 

      
      shortcut.add("f7", function() {
          // Do something

          $("#pembayaran_penjualan").focus();

      }); 

      
      shortcut.add("f8", function() {
          // Do something

          $("#penjualan").click();

      }); 

      
      shortcut.add("f9", function() {
          // Do something

          $("#piutang").click();

      }); 

      
      shortcut.add("f10", function() {
          // Do something

          $("#simpan_sementara").click();

      }); 

      
      shortcut.add("ctrl+b", function() {
          // Do something

      var session_id = $("#session_id").val()

          window.location.href="batal_penjualanorder.php?session_id="+session_id+"";


      }); 

       shortcut.add("ctrl+k", function() {
          // Do something

          $("#cetak_langsung").click();


      }); 
  </script>
  <!-- SHORTCUT -->



<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>