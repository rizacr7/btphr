
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Lap.Saldo Hutang Sewa</h3>
  </div>
  <div class="card">
    <div class="card-header">
        <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-12">
            <select class="form-select form-control" name="bulan" id="bulan">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" placeholder="TAHUN" name='tahun' id='tahun' class="form-control" required="true" onkeyup="uppercase(this)" value="<?php echo date("Y")?>">
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <input type="button" onclick="viewreport()" value="View" class="btn btn-sm btn-info">
            <input type="button" onclick="sinkronhutang()" value="Sinkron" class="btn btn-sm btn-warning">
            <input type="button" onclick="exceldt()" value="Excel" class="btn btn-sm btn-success">
          </div>
        </div>
    </div>
    <div class="card-body">
        <div class="spinner-border" role="status" id="loading" style="display:none">
          <span class="visually-hidden">Loading...</span>
        </div>
        <div class="table-responsive">
          <div class="box-body" id="div_tabel_data"></div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function viewreport() {
		var bulan = $('#bulan').val();
		var tahun = $('#tahun').val();
      $.ajax({
      data : "bulan="+bulan+"&tahun="+tahun,
      type:"POST",
      url: "<?php echo base_url(); ?>index.php/report/tab_hutang",
      beforeSend: function () {
      $("#loading").show();
      },
      success: function (res) {
      $("#div_tabel_data").html(res);
      $("#loading").hide();
    }
    }); 
  }
	
  function sinkronhutang(){
    var bulan = $('#bulan').val();
    var tahun = $('#tahun').val();
    dataurl = "<?php echo base_url(); ?>index.php/report/sinkron_hutang";
    $.ajax({
        data : 'bulan='+bulan+'&tahun='+tahun,
        url  : dataurl,
        type : "POST",
        beforeSend:function(){
          $('#loading').show();
        }, 
        success : function(res) {
         
          $("#div_tabel_data").html(res);
          $("#loading").hide();
          Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: 'Data berhasil disinkron',
            timer: 1500,
            showConfirmButton: false
          });
          
        }
    });
  }

  function exceldt(){
		var bulan = $('#bulan').val();
		var tahun = $('#tahun').val();
		window.open("<?php echo base_url(); ?>index.php/report/excel_saldohutang?bulan="+bulan+"&tahun="+tahun);
	}

</script>

        
