
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Lap.Kartu Hutang Sewa</h3>
  </div>
  <div class="card">
    <div class="card-header">
        <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" placeholder="Periode" name='tanggal' id='tanggal' class="form-control" required="true" onkeyup="uppercase(this)" value="<?php echo date("d-m-Y")?>">
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
  $("#tanggal").datepicker({
		format:'dd-mm-yyyy'
	})

  function viewreport() {
		var tanggal = $('#tanggal').val();
      $.ajax({
      data : "tanggal="+tanggal,
      type:"POST",
      url: "<?php echo base_url(); ?>index.php/report/tab_kartuhutang",
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
		var tanggal = $('#tanggal').val();
		window.open("<?php echo base_url(); ?>index.php/report/excel_kartuhutang?tanggal="+tanggal);
	}

</script>

        
