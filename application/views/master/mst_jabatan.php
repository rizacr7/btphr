
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Master Jabatan</h3>
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
                  <div class="form-group">
                    <label>Kd.Jabatan</label>
                    <input type="text" id="kd_jab" name="kd_jab" class="form-control" onkeyup="uppercase(this)" required>
                  </div>
                  <div class="form-group">
                    <label>Nm.Jabatan</label><br>
                    <input type="text" id="nm_jab" name="nm_jab" class="form-control" onkeyup="uppercase(this)" required>
                  </div>
                  <div class="form-group">
                    <label>Tj.Jabatan</label><br>
                    <input type="text" id="tj_jab" name="tj_jab" class="form-control" onkeyup="harga('tj_jab')" required>
                  </div>
                  <div class="form-group" style="display: none">
                    <label>ID</label><br>
                    <input type="text" id="id_jab" name="id_jab" class="form-control" readonly="true">
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
			url: '<?php echo base_url(); ?>index.php/master/tab_jabatan',
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
    var table = $('#table_jabatan').DataTable();
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

    var id_jab = selectedData[1];
    var kd_jab = selectedData[2];
    var nm_jab = selectedData[3];
    var tj_jab = selectedData[4];
   
    $('#id_jab').val(id_jab);
    $('#kd_jab').val(kd_jab);
    $('#nm_jab').val(nm_jab);
    $('#tj_jab').val(tj_jab);
   
    $('#myModal').modal('show');
    $('#myModal').on('shown.bs.modal', function () {
      // Bisa tambahkan fokus ke field tertentu kalau mau
      $('#kd_jab').focus();
    });
  }

  function simpan() {
    var data = $('#formModal').serialize();

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/master/simpan_jabatan',
      type: 'POST',
      data: data,
      success: function(response) {
        if(response == "success"){
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil disimpan',
            showConfirmButton: false,
            timer: 1500
          });
          closemodal();
          loadData();
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            text: 'Gagal menyimpan data.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        }
      },
      error: function(xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Gagal menyimpan data.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  function hapus() {
    var table = $('#table_jabatan').DataTable();
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

    var id_jab = selectedData[1];

    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data Jabatan akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>index.php/master/hapus_jabatan',
          type: 'POST',
          data: { id_jab: id_jab },
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
              text: 'Gagal menghapus data.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        });
      }
    });
  }
</script>

        
