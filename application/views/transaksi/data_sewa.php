
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Data Sewa Kendaraan</h3>
  </div>
  <div class="card">
    <div class="card-header">
        <button class="btn btn-warning" onclick="edit()">Update Data Penghentian</button>
        <button class="btn btn-danger" onclick="bataldt()">Batal Penghentian</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
          <div class="box-body" id="div_tabel_data"></div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Form Penghentian</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <form id="formModal" onsubmit="return false">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>Nopol</label>
                    <input type="text" id="nopol" name="nopol" class="form-control" onkeyup="uppercase(this)" readonly>
                  </div>
                  <div class="form-group">
                    <label>Nm.Kendaraan</label><br>
                    <input type="text" id="nm_kendaraan" name="nm_kendaraan" class="form-control" onkeyup="uppercase(this)" readonly>
                  </div>
                  <div class="form-group">
                    <label>Tgl.Penghentian</label><br>
                    <input type="text" id="tgl_stop" name="tgl_stop" class="form-control">
                  </div>
                  <div class="form-group" style="display: none">
                    <label>ID</label><br>
                    <input type="text" id="id_spk" name="id_spk" class="form-control" readonly="true">
                  </div>
                </div>
                
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="simpan()">Simpan</button>
            <button type="button" class="btn btn-danger" onclick="closemodal()">Batal</button>
          </div>

        </div>
      </div>
    </div>
    <!-- end modal -->
      
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function() {
    loadData();

    $('#tgl_stop').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true,
    });
  });

  function loadData() {
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/transaksi/tab_sewakendaraan',
			success: function (res) {
				$("#div_tabel_data").html(res);
			}
		});

	}

  function closemodal() {
    $('#myModal').modal('hide');
  }

  function edit() {
    var table = $('#table_sewa').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data kendaraan yang akan diedit.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_spk = selectedData[1];
    var nm_kendaraan = selectedData[2];
    var nopol = selectedData[3];
    var tgl_stop = selectedData[9];
    
    $('#id_spk').val(id_spk);
    $('#tgl_stop').val(tgl_stop);
    $('#nm_kendaraan').val(nm_kendaraan);
    $('#nopol').val(nopol);

    $('#myModal').modal('show');
    $('#myModal').on('shown.bs.modal', function () {
    });
  }

  function simpan() {
    var data = $('#formModal').serialize();

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/transaksi/update_stopsewa',
      type: 'POST',
      data: data,
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Data berhasil diupdate',
          showConfirmButton: false,
          timer: 1500
        });
        closemodal();
        loadData();
      },
      error: function(xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Gagal menyimpan data kendaraan.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  function bataldt() {
    var table = $('#table_sewa').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data kendaraan yang akan dibatalkan penghentiannya.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_spk = selectedData[1];

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/transaksi/batal_stopsewa',
      type: 'POST',
      data: { id_spk: id_spk },
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Penghentian berhasil dibatalkan',
          showConfirmButton: false,
          timer: 1500
        });
        loadData();
      },
      error: function(xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Gagal membatalkan penghentian.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

</script>

        
