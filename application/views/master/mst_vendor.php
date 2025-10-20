
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Master Kendaraan</h3>
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
                      <label>Nama Vendor</label><br>
                      <input type="text" id="nm_vendor" name="nm_vendor" class="form-control" onkeyup="uppercase(this)" required>
                    </div>
                    <div class="form-group">
                      <label>Alamat</label><br>
                      <textarea name="alamat" id="alamat" class="form-control" onkeyup="uppercase(this)"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Telp / Hp</label><br>
                      <input type="text" id="telp" name="telp" class="form-control" onkeyup="uppercase(this)">
                    </div>
                    <div class="form-group">
                      <label>Npwp</label><br>
                      <input type="text" id="npwp" name="npwp" class="form-control" onkeyup="uppercase(this)">
                    </div>
                    <div class="form-group">
                      <label>Bank</label><br>
                      <input type="text" id="bank" name="bank" class="form-control" onkeyup="uppercase(this)">
                    </div>
                    <div class="form-group">
                      <label>No.Rekening</label><br>
                      <input type="text" id="no_rek" name="no_rek" class="form-control" onkeyup="uppercase(this)">
                    </div>
                    <div class="form-group">
                      <label>Atas Nama</label><br>
                      <input type="text" id="atas_nama" name="atas_nama" class="form-control" onkeyup="uppercase(this)">
                    </div>
                    <div class="form-group" style='display:none'>
                      <label>ID</label><br>
                      <input type="text" id="id_vendor" name="id_vendor" class="form-control" readonly="true">
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
			url: '<?php echo base_url(); ?>index.php/master/tab_vendor',
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
    var table = $('#table_vendor').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data vendor yang akan diedit.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_vendor = selectedData[1];
    
    $.ajax({
      url: '<?php echo base_url(); ?>index.php/master/ajaxdtvendor',
      type: 'POST',
      data: { id_vendor: id_vendor },
      dataType: 'json',
      success: function(response) {
        $('#id_vendor').val(response.id_vendor);
        $('#nm_vendor').val(response.nm_vendor);
        $('#alamat').val(response.alamat);
        $('#telp').val(response.telp);
        $('#npwp').val(response.npwp);
        $('#bank').val(response.bank);
        $('#no_rek').val(response.no_rek);
        $('#atas_nama').val(response.atas_nama);
        
        $('#myModal').modal('show');
      },
      error: function(xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Gagal mengambil data vendor.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  function simpan() {
    var form = $('#formModal');

    // Cek semua input/textarea/select yang wajib diisi (punya atribut required)
    var isValid = true;
    form.find('[required]').each(function() {
      if ($.trim($(this).val()) === '') {
        isValid = false;

        // Fokuskan ke field yang kosong pertama
        $(this).focus();

        // Tampilkan SweetAlert peringatan
        Swal.fire({
          icon: 'warning',
          title: 'Data belum lengkap',
          text: 'Field "' + ($(this).attr('placeholder') || $(this).attr('name')) + '" wajib diisi.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });

        // Hentikan looping
        return false;
      }
    });

    // Jika tidak valid, hentikan proses simpan
    if (!isValid) return;

    // Jika semua valid, lanjutkan simpan
    var data = form.serialize();

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/master/simpan_vendor',
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
    var table = $('#table_vendor').DataTable();
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

    var id_vendor = selectedData[1];

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
          url: '<?php echo base_url(); ?>index.php/master/hapus_vendor',
          type: 'POST',
          data: { id_vendor: id_vendor },
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

        
