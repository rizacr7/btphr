
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Master Level Jabatan</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	<button class="btn btn-primary btn-sm" onclick="add()">Add</button>
        <button class="btn btn-warning btn-sm" onclick="edit()">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="hapus()">Delete</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
          <div class="box-body" id="div_tabel_data"></div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Form Level Jabatan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <form id="formModal" onsubmit="return false">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label>Jabatan</label><br>
                    <select id="kd_jab" name="kd_jab" class="form-select form-control" style="width:100%">
                      <option value="">-Pilih-</option>
                    </select>
                  </div>
                  <div class="form-group">
                      <label><b>Gaji Pokok</b></label><br>
                      <input type="text" id="gapok" name="gapok" class="form-control" onkeyup="harga('gapok')">
                  </div>
                  <div class="form-group" style="display:none">
                    <label>ID</label><br>
                    <input type="text" id="id_leveljab" name="id_leveljab" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label>Level</label><br>
                    <input type="text" id="level" name="level" class="form-control" onkeyup="harga('level')" required>
                  </div>
                </div>
              </div>
              <div class="row">
                  <b>Tunjangan Tetap</b>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Tj.Jabatan</label><br>
                      <input type="text" id="tj_jabatan" name="tj_jabatan" class="form-control" onkeyup="harga('tj_jabatan')">
                    </div>
                    <div class="form-group">
                      <label>Tj.Transport</label><br>
                      <input type="text" id="tj_transport" name="tj_transport" class="form-control" onkeyup="harga('tj_transport')">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Tj.Komunikasi</label><br>
                      <input type="text" id="tj_komunikasi" name="tj_komunikasi" class="form-control" onkeyup="harga('tj_komunikasi')">
                    </div>
                    <div class="form-group">
                      <label>Tj.Konsumsi</label><br>
                      <input type="text" id="tj_konsumsi" name="tj_konsumsi" class="form-control" onkeyup="harga('tj_konsumsi')">
                    </div>
                  </div>
              </div>
              <div class="row">
                  <b>Tunjangan Tidak Tetap</b>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Tj.Kinerja</label><br>
                      <input type="text" id="tj_kinerja" name="tj_kinerja" class="form-control" onkeyup="harga('tj_kinerja')">
                    </div>
                    <div class="form-group">
                      <label>Tj.Lembur</label><br>
                      <input type="text" id="tj_lembur" name="tj_lembur" class="form-control" onkeyup="harga('tj_lembur')">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <label>Tj.HR</label><br>
                      <input type="text" id="tj_hr" name="tj_hr" class="form-control" onkeyup="harga('tj_hr')">
                    </div>
                    <div class="form-group">
                      <label>Tj.Kehadiran</label><br>
                      <input type="text" id="tj_kehadiran" name="tj_kehadiran" class="form-control" onkeyup="harga('tj_kehadiran')">
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
			url: '<?php echo base_url(); ?>index.php/master/tab_leveljab',
			success: function (res) {
				$("#div_tabel_data").html(res);
			}
		});
	}

  $('#kd_jab').select2({
    placeholder: 'Pilih Jabatan',
    dropdownParent: $('#myModal'),
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_jabatan_select2',
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

  function add() {
    $(':input').val('');
    $('#myModal').modal('show');
    $('#myModal').on('shown.bs.modal', function () {
    });
    $('#level').prop('readonly', false);
    $('#kd_jab').val(null).trigger('change');
  }

  function closemodal() {
    $('#myModal').modal('hide');
  }

  function edit() {
    var table = $('#table_leveljab').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data yang akan diedit.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_leveljab = selectedData[1];
    
    $.ajax({
      url: '<?php echo base_url(); ?>index.php/master/ajaxdtleveljab',
      type: 'GET',
      data: { id_leveljab: id_leveljab },
      dataType: 'json',
      success: function(response) {
        $('#id_leveljab').val(response.id_leveljab);
        $('#level').val(response.level).prop('readonly', true);;
        $("#kd_jab").empty().append('<option value="'+response.kd_jab+'">'+response.kd_jab+"|"+response.nm_jab+'</option>').val(response.kd_jab).trigger('change');

        $('#gapok').val(response.gaji);
        $('#tj_jabatan').val(response.tjjabatan);
        $('#tj_transport').val(response.tjtransport);
        $('#tj_komunikasi').val(response.tjkomunikasi);
        $('#tj_konsumsi').val(response.tjkonsumsi);

        $('#tj_kinerja').val(response.tjkinerja);
        $('#tj_lembur').val(response.tjlembur);
        $('#tj_hr').val(response.tjhr);
        $('#tj_kehadiran').val(response.tjkehadiran);
        
        $('#myModal').modal('show');
      },
      error: function(xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Gagal mengambil data.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  function simpan() {
    var data = $('#formModal').serialize();

    let kd_jab = $("#kd_jab").val().trim();
    let level = $("#level").val().trim();
    let gapok = $("#gapok").val().trim();

    // Validasi input kosong
    if (kd_jab === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Jabatan harus diisi!'
      });
      return false;
    }
    if (level === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Level harus diisi!'
      });
      return false;
    }
    if (gapok === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Gaji Pokok harus diisi!'
      });
      return false;
    }

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/master/simpan_leveljab',
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
            text: 'Gagal menyimpan data. Kode Level Sudah Ada',
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
    var table = $('#table_leveljab').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data yang akan dihapus.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_leveljab = selectedData[1];

    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>index.php/master/hapus_leveljabatan',
          type: 'POST',
          data: { id_leveljab: id_leveljab },
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

        
