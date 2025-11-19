
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Approval Data</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	Approval Data
    </div>
    <div class="card-body">
        <form id="formModal" onsubmit="return false">
          <div class="row" id="headerform">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Bulan</label><br>
                 <select id="bulan" class="form-select form-control">
                    <option value="">-- Pilih Bulan --</option>
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
              <div class="form-group">
                <button class="btn btn-success" onclick="viewdata()"> View</button>

                <div class="spinner-border" role="status" id="loading" style="display:none">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Tahun</label><br>
                <select id="tahun" class="form-select form-control"></select>
              </div>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="table-responsive">
            <div class="box-body" id="div_tabel_data"></div>
          </div>
        </div>
       
    </div>
      
  </div>
</div>

<script type="text/javascript">

var tahunSekarang = new Date().getFullYear();
var tahunMulai = tahunSekarang - 3;

var selectTahun = document.getElementById("tahun");

for (var t = tahunMulai; t <= tahunSekarang; t++) {
  var opt = document.createElement("option");
  opt.value = t;
  opt.innerHTML = t;
  selectTahun.appendChild(opt);
}

// set default tahun sekarang
selectTahun.value = tahunSekarang;


// ----------------------
// SET BULAN SEKARANG
// ----------------------
var bulanSekarang = String(new Date().getMonth() + 1).padStart(2, '0');
document.getElementById("bulan").value = bulanSekarang;

function viewdata(){
    let bulan = $("#bulan").val();
    let tahun = $("#tahun").val();
    $.ajax({
      data : "bulan="+bulan+"&tahun="+tahun,
      type:"POST",
      url: "<?php echo base_url(); ?>index.php/approval/tab_approve",
      beforeSend: function () {
      $("#loading").show();
      },
      success: function (res) {
      $("#div_tabel_data").html(res);
      $("#loading").hide();
    }
    }); 
}

function approvedt(kdjenis){
    let bulan = $("#bulan").val();
    let tahun = $("#tahun").val();
    $.ajax({
      data : "bulan="+bulan+"&tahun="+tahun+"&kdjenis="+kdjenis,
      type:"POST",
      url: "<?php echo base_url(); ?>index.php/approval/approve_doc",
      beforeSend: function () {
      $("#loading").show();
      },
      success: function (res) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil diapprove',
        showConfirmButton: false,
        timer: 1500
      });
      viewdata()
      $("#loading").hide();
    }
    }); 
}

function bataldt(kdjenis){
    let bulan = $("#bulan").val();
    let tahun = $("#tahun").val();
    $.ajax({
      data : "bulan="+bulan+"&tahun="+tahun+"&kdjenis="+kdjenis,
      type:"POST",
      url: "<?php echo base_url(); ?>index.php/approval/batal_doc",
      beforeSend: function () {
      $("#loading").show();
      },
      success: function (res) {
      Swal.fire({
        icon: 'success',
        title: 'Data berhasil dibatalkan',
        showConfirmButton: false,
        timer: 1500
      });
      viewdata()
      $("#loading").hide();
    }
    }); 
}
</script>

        
