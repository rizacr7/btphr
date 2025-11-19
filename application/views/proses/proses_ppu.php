
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Proses PPU Sifina</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	Proses PPU Sifina
    </div>
    <div class="card-body">
        <form id="formModal" onsubmit="return false">
          <div class="row" id="headerform">
            <div class="col-md-4 col-sm-4 col-xs-12">
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
                <button class="btn btn-info" onclick="prosesppu()" id="btnproses"> Proses</button>
                <button class="btn btn-success" onclick="viewppu()"> View</button>

                <div class="spinner-border" role="status" id="loading" style="display:none">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label>Tahun</label><br>
                <select id="tahun" class="form-select form-control"></select>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
              <div class="form-group">
                <label>Jenis</label><br>
                <select id="jns_ppu" class="form-select form-control">
                    <option value="">-- Pilih Jenis PPu --</option>
                  </select>
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

$('#jns_ppu').select2({
  placeholder: 'Pilih Jenis PPU',
  ajax: {
    url: '<?php echo base_url(); ?>index.php/combo/get_ppu_select2',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
      return {
        results: data
      };
    },
    cache: true
  }
});

function prosesppu(){
    let bulan = $("#bulan").val();
    let tahun = $("#tahun").val();
    let jenis = $("#jns_ppu").val();
    dataurl = "<?php echo base_url(); ?>index.php/proses/proses_ppusifina";
		$.ajax({
			url: dataurl,
			data: "bulan="+bulan+"&tahun="+tahun+"&jenis="+jenis,
			type: "POST",
			beforeSend: function () {
        if(jenis == ""){
           Swal.fire({
            icon: 'error',
            title: 'Pilih Jenis PPU',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
          return false;
        }
				$("#loading").show();
        $("#btnproses").hide();
        
			},
			success: function (res) {
				if (res == 200) {
					$("#loading").hide();
          $("#btnproses").show();
					Swal.fire({
            icon: 'success',
            title: 'Data berhasil diproses',
            showConfirmButton: false,
            timer: 1500
          });
				}
        else{
          $("#loading").hide();
          $("#btnproses").show();
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            text: 'Gagal proses ppu.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
			}
		});
}

function viewppu(){
    let bulan = $("#bulan").val();
    let tahun = $("#tahun").val();
    let jenis = $("#jns_ppu").val();
    $.ajax({
      data : "bulan="+bulan+"&tahun="+tahun+"&jenis="+jenis,
      type:"POST",
      url: "<?php echo base_url(); ?>index.php/proses/tab_ppu",
      beforeSend: function () {
      $("#loading").show();
      },
      success: function (res) {
      $("#div_tabel_data").html(res);
      $("#loading").hide();
    }
    }); 
}

function pdfcetak(bukti){
		window.open("<?php echo base_url(); ?>index.php/proses/pdf_ppu_bukti?bukti="+bukti);
	}
</script>

        
