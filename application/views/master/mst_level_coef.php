
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Master Level Koefisien</h3>
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
                      <label>Kode Unit</label><br>
                      <select id="kd_unit" name="kd_unit">
                        <option value="">-Pilih-</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Kode Level</label><br>
                      <select id="id_level" name="id_level">
                        <option value="">-Pilih-</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Koefisien (%)</label><br>
                      <input type="text" id="coef" name="coef" class="form-control" onkeyup="harga('coef')">
                    </div>
                    <div class="form-group" style='display:none'>
                      <label>ID</label><br>
                      <input type="text" id="id_coef" name="id_coef" class="form-control" readonly="true">
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
			url: '<?php echo base_url(); ?>index.php/umr/tab_coef',
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

  
	function edit()
	{
		var row = $('#table_coef').DataTable().row({selected: true}).data();
		
		//Ajax Load data from ajax
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/umr/ajaxdtcoef",
			data: "id_coef=" + row[1],
			type: "GET",
			dataType: "JSON",
			success: function (data)
			{
				$('[name="id_coef"]').val(data.id_coef);
				$('[name="coef"]').val(data.coef_level);
				$("#kd_unit").empty().append('<option value="'+data.kd_unit+'">'+data.kd_unit+"|"+data.nm_unit+'</option>').val(data.kd_unit).trigger('change');
				$("#id_level").empty().append('<option value="'+data.id_level+'">'+data.id_level+"|"+data.ket_level+'</option>').val(data.id_level).trigger('change');
				$('#myModal').modal('show'); // show bootstrap modal when complete loaded
			}
		});
	}
	
	function simpan() {
		data = $('#formModal').serialize();
		dataurl = "<?php echo base_url(); ?>index.php/umr/ins_coef_level";
		$.ajax({
			url: dataurl,
			data: data,
			type: "POST",
			beforeSend: function () {
				if ($('[name="kd_unit"]').val() == '') {
					Swal.fire({
            icon: 'warning',
            title: 'Kode Unit Harus Diisi',
            text: 'Kode Unit Harus Diisi.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
					return false;
				}
				else if ($('[name="id_level"]').val() == '') {
					Swal.fire({
            icon: 'warning',
            title: 'Level Pegawai Harus Diisi',
            text: 'Level Pegawai Harus Diisi.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
					return false;
				}
				else if ($('[name="coef"]').val() == '') {
					Swal.fire({
            icon: 'warning',
            title: 'Koefisien Harus Diisi',
            text: 'Koefisien Harus Diisi.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
					return false;
				}
			},
			success: function (res) {
				if (res == 1) {
					$('#myModal').modal('hide');
					loadData();
					Swal.fire({
            icon: 'success',
            title: 'Data berhasil disimpan',
            showConfirmButton: false,
            timer: 1500
          });
				} else if (res == 2) {
					Swal.fire({
            icon: 'warning',
            title: 'Data Sudah Ada',
            text: 'Data Sudah Ada',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
				} else if (res == 3) {
					$('#myModal').modal('hide');
					loadData();
					Swal.fire({
            icon: 'success',
            title: 'Data berhasil disimpan',
            showConfirmButton: false,
            timer: 1500
          });
				} 
			}
		});
	}
	
	function hapus() {
		var row = $('#table_coef').DataTable().row({selected: true}).data();
		if(row) {
			Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data Ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
      if (result.isConfirmed) {
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/umr/hapuscoef",
					data: "id_coef=" +row[1],
					dataType: "json",
					type: "post",
					success: function(res) {
						if (res == 1) {
							loadData();
							Swal.fire({
                icon: 'success',
                title: 'Data berhasil dihapus',
                showConfirmButton: false,
                timer: 1500
              });
						} 
					}
				});
			}
      });
		}
	}
	
	$("#kd_unit").select2({
		dropdownParent: $("#myModal"),
		width: '100%',
		ajax: {
			url: "<?php echo base_url(); ?>index.php/combo/combo_unit",
			dataType: 'json',
			delay: 500
		}
	});

	$("#id_level").select2({
		dropdownParent: $("#myModal"),
		width: '100%',
		ajax: {
			url: "<?php echo base_url(); ?>index.php/combo/combo_level_btp",
			dataType: 'json',
			delay: 500
		}
	});


</script>

        
