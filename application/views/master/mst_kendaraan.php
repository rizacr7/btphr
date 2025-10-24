
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Master Kendaraan</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	<button class="btn btn-primary" onclick="add()">Add</button>
        <button class="btn btn-warning" onclick="edit()">Edit</button>
        <button class="btn btn-danger" onclick="hapus()">Delete</button>
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
            <h4 class="modal-title" id="myModalLabel">Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <form id="formModal" onsubmit="return false">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="display: none">
                    <label>Kd.Kendaraan</label>
                    <input type="text" id="kd_kendaraan" name="kd_kendaraan" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>Nm.Kendaraan</label><br>
                    <input type="text" id="nm_kendaraan" name="nm_kendaraan" class="form-control" onkeyup="uppercase(this)" required>
                  </div>
                  <div class="form-group">
                    <label>Jenis Kendaraan</label><br>
                    <select name="jns_kend" id="jns_kend" class="form-select">
                      <option value="MINIBUS">MINIBUS</option>
                      <option value="TRUCK">TRUCK</option>
                      <option value="MOTOR">MOTOR</option>
                      <option value="FORKLIFT">FORKLIFT</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Bahan Bakar</label><br>
                    <select name="bbm" id="bbm" class="form-select">
                      <option value="BENSIN">BENSIN</option>
                      <option value="SOLAR">SOLAR</option>
                    </select>
                  </div>
                  <div class="form-group" style="display: none">
                    <label>ID</label><br>
                    <input type="text" id="id_kendaraan" name="id_kendaraan" class="form-control" readonly="true">
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
  });

  function loadData() {
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/master/tab_kendaraan',
			success: function (res) {
				$("#div_tabel_data").html(res);
			}
		});

	}

  function add() {
    $(':input').val('');
    $('#myModal').modal('show');
    $('#myModal').on('shown.bs.modal', function () {
    });
  }

  function closemodal() {
    $('#myModal').modal('hide');
  }

  function edit() {
    var table = $('#table_kendaraan').DataTable();
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

    var id_kendaraan = selectedData[1];
    var kd_kendaraan = selectedData[2];
    var nm_kendaraan = selectedData[3];
    var jns_kend = selectedData[4];
    var bbm = selectedData[5];

    $('#id_kendaraan').val(id_kendaraan);
    $('#kd_kendaraan').val(kd_kendaraan);
    $('#nm_kendaraan').val(nm_kendaraan);
    $('#jns_kend').val(jns_kend);
    $('#bbm').val(bbm);

    $('#myModal').modal('show');
    $('#myModal').on('shown.bs.modal', function () {
      // Bisa tambahkan fokus ke field tertentu kalau mau
      $('#kd_kendaraan').focus();
    });
  }

  function simpan() {
    var data = $('#formModal').serialize();

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/master/simpan_kendaraan',
      type: 'POST',
      data: data,
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Data berhasil disimpan',
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

  function hapus() {
    var table = $('#table_kendaraan').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data kendaraan yang akan dihapus.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_kendaraan = selectedData[1];

    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data kendaraan akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>index.php/master/hapus_kendaraan',
          type: 'POST',
          data: { id_kendaraan: id_kendaraan },
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Data berhasil dihapus',
              showConfirmButton: false,
              timer: 1500
            });
            loadData();
          },
          error: function(xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Terjadi kesalahan',
              text: 'Gagal menghapus data kendaraan.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        });
      }
    });
  }
</script>

        
