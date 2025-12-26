
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Pengajuan Pegawai OS</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	<!-- <button class="btn btn-primary btn-sm" onclick="add()">Add</button>
        <button class="btn btn-warning btn-sm" onclick="edit()">Edit</button> -->
        <button class="btn btn-danger btn-sm" onclick="hapus()">Delete</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
          <div class="box-body" id="div_tabel_data"></div>
        </div>
    </div>

  </div>
</div>

<script type="text/javascript">


  $(document).ready(function() {
    loadData();
  });

  function loadData() {
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/maspegos/tab_pengajuan_os',
			success: function (res) {
				$("#div_tabel_data").html(res);
			}
		});

	}

  function hapus() {
    var table = $('#table_pegawai').DataTable();
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

    var id_pegawai = selectedData[1];

    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data Pegawai akan dihapus secara permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>index.php/maspegos/hapus_pengajuan_os',
          type: 'POST',
          data: { id_pegawai: id_pegawai },
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

        
