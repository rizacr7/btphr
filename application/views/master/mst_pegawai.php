
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Master Pegawai</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	Form Master Pegawai
    </div>
    <div class="card-body">
       
    </div>
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
   
    $('#id_jab').val(id_jab);
    $('#kd_jab').val(kd_jab);
    $('#nm_jab').val(nm_jab);
   
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

        
