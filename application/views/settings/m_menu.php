
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Data Menu</h3>
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
                    <label>Nm.Menu</label><br>
                    <input type="text" id="judul_sub" name="judul_sub" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Controller</label><br>
                    <input type="text" id="controller" name="controller" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Link</label><br>
                    <input type="text" id="link" name="link" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Header Menu</label><br>
                    <select class="form-control" name="id_head" id="id_head" style="width:100%;height:100%;">
                      <option value="">--Pilih--</option>
                    </select>
                  </div>
                  <div class="form-group" style='display:none'>
                    <label>ID</label><br>
                    <input type="text" id="id_sub" name="id_sub" class="form-control" readonly="true">
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
			url: '<?php echo base_url(); ?>index.php/settings/tab_menu',
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

  
  $('#id_head').select2({
    placeholder: 'Pilih Header Menu',
    dropdownParent: $('#myModal'),
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_header_select2',
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

  function hapus() {
    var table = $('#table_menu').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data user yang akan dihapus.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_sub = selectedData[1];

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
          url: '<?php echo base_url(); ?>index.php/settings/hapus_menu',
          type: 'POST',
          data: { id_sub: id_sub },
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
              text: 'Gagal menghapus data user.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'OK'
            });
          }
        });
      }
    });
  }

  
  function simpan(){
    var formData = $('#formModal').serialize();
    $.ajax({
      url: '<?php echo base_url(); ?>index.php/settings/simpan_menu',
      type: 'POST',
      data: formData,
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
          text: 'Gagal menyimpan data user.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  function edit(){
    var table = $('#table_menu').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data user yang akan diedit.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_sub = selectedData[1];

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/settings/get_menu_by_id',
      type: 'POST',
      data: { id_sub: id_sub },
      dataType: 'json',
      success: function(response) {
        $('#id_sub').val(response.id_sub);
        $('#controller').val(response.controller);
        $('#link').val(response.link);
        $('#judul_sub').val(response.judul_sub);
        $("#id_head").empty().append('<option value="'+response.id_head+'">'+response.judul_head+'</option>').val(response.id_head).trigger('change');

        $('#myModal').modal('show');
      },
      error: function(xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi kesalahan',
          text: 'Gagal mengambil data user.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
      }
    });
  }

</script>

        
