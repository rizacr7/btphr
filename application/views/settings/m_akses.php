
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Akses Menu</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	<div class="row">
          <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="form-group">
              <label>User Group</label>
              <select name="level" id="level" class="form-control">
                <option value="">--Pilih--</option>
              </select>
            </div>
          </div>
        
          <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="form-group">
              <label></label><br>
              <button type="button" class="btn btn-primary btn-sm" onclick="viewdt()">View</button>		
            </div>
          </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
          <button type="button" onclick="add()" class="btn btn-primary waves-effect waves-light m-b-5" id="tombol1" style="display:none">Add</button>
					<button type="button" onclick="hapus()" class="btn btn-danger waves-effect waves-light m-b-5" id="tombol2" style="display:none">Delete</button>
					<br><br>
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
                      <label>Header Menu</label><br>
                      <select class="form-control" name="id_header" id="id_header" style="width:100%">
                        <option value="">--Pilih--</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Menu</label><br>
                      <select id="id_sub_menu" name="id_sub_menu" class="form-control" style="width:100%">
                        <option value="">-Pilih-</option>
                      </select>
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


 function viewdt() {
    var level = $('#level').val();
    $.ajax({
    data : "level="+level, 
    type:"POST",
    url: '<?php echo base_url(); ?>index.php/settings/tab_akses',
    beforeSend: function () {
      $("#loading").show();
    },
      success: function (res) {
      $("#loading").hide();
      $("#tombol1").show();
      $("#tombol2").show();
      $("#div_tabel_data").html(res);
      }
  });
}

  function add() {
    $('#myModal').modal('show');
    $('#myModal').on('shown.bs.modal', function () {
    });
  }

  function closemodal() {
    $('#myModal').modal('hide');
  }

  
  $('#level').select2({
    placeholder: 'Pilih Role Menu',
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_role_select2',
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

  $('#id_header').select2({
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

  $('#id_sub_menu').select2({
    placeholder: 'Pilih Sub Menu',
    dropdownParent: $('#myModal'),
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_menu_select2',
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
    var table = $('#table_akses').DataTable();
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

    var id = selectedData[1];

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
          url: '<?php echo base_url(); ?>index.php/settings/hapus_akses',
          type: 'POST',
          data: { id: id },
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Data berhasil dihapus',
              showConfirmButton: false,
              timer: 1500
            });
           viewdt();
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
    var level = $('#level').val();
    var id_header = $('#id_header').val();
    var id_sub_menu = $('#id_sub_menu').val();

    $.ajax({
      data : "level="+level+"&id_header="+id_header+"&id_sub_menu="+id_sub_menu, 
      type:"POST",
      url: '<?php echo base_url(); ?>index.php/settings/simpan_akses',
      beforeSend: function () {
        $("#loading").show();
      },
      success: function(response) {
        if(response == 'error') {
          Swal.fire({
            icon: 'warning',
            title: 'Data sudah ada',
            text: 'Akses menu untuk role ini sudah ada.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
          $("#loading").hide();
          return;
        }
        else{
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil disimpan',
            showConfirmButton: false,
            timer: 1500
          });
          $("#loading").hide();
          $('#myModal').modal('hide');
          viewdt();
        }
       
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


</script>

        
