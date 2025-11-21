
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Lap.BPJS Pegawai</h3>
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
              <select class="form-select form-control" name="jenis" id="jenis">
                <option value="1">BPJS Kesehatan</option>
                <option value="2">BPJS Tenaga Kerja</option>
                <option value="3">BPJS Pensiun</option>
              </select>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-12">
            <input type="button" onclick="viewreport()" value="View" class="btn btn-sm btn-info">
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

  var bulanSekarang = String(new Date().getMonth() + 1).padStart(2, '0');
  document.getElementById("bulan").value = bulanSekarang;

  function viewreport() {
		var bulan = $('#bulan').val();
		var tahun = $('#tahun').val();
    var jenis = $('#jenis').val();
      $.ajax({
      data : "bulan="+bulan+"&tahun="+tahun+"&jenis="+jenis,
      type:"POST",
      url: "<?php echo base_url(); ?>index.php/report/tab_bpjs",
      beforeSend: function () {
      $("#loading").show();
      },
      success: function (res) {
      $("#div_tabel_data").html(res);
      $("#loading").hide();
    }
    }); 
  }
	
  function exceldt(){
		var bulan = $('#bulan').val();
		var tahun = $('#tahun').val();
    var jenis = $('#jenis').val();
		window.open("<?php echo base_url(); ?>index.php/report/excel_bpjs?bulan="+bulan+"&tahun="+tahun+"&jenis="+jenis);
	}

</script>

        
