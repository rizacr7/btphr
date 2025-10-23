
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">View SPK Sewa kendaraan</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	<button class="btn btn-primary btn-sm" onclick="viewdt()">View</button>
        <button class="btn btn-warning btn-sm" onclick="edit()">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="hapus()">Delete</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
          <div class="box-body" id="div_tabel_data"></div>
        </div>
    </div>

    <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Spk Sewa Kendaraan</h4>
            </div>
            <div class="modal-body-view">
            </div>
          <div class="modal-footer"> <!-- modal footer -->
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closemodal()">Batal</button>
          </div>
          </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
      </div>
      
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function() {
    loadData();
  });

  function loadData() {
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/transaksi/tab_spk',
			success: function (res) {
				$("#div_tabel_data").html(res);
			}
		});

	}

  function viewdt() {
 		$('#viewmodal').modal('show')
 		var row = $('#table_spk').DataTable().row({selected: true}).data();
 		var url = "<?php echo base_url(); ?>index.php/transaksi/v_spk_sewa";			
		no_bukti_spk = row[1];	
		$.post(url, {no_bukti_spk: no_bukti_spk} ,function(data) {				
			$(".modal-body-view").html(data).show();
		});
	}

  function closemodal() {
    $('#viewmodal').modal('hide');
  }

  function hapus() {
    var row = $('#table_spk').DataTable().row({selected: true}).data();
    if (!row) {
      alert('Pilih data yang akan dihapus!');
      return;
    }
    if (confirm('Yakin akan menghapus data SPK ' + row[1] + ' ?')) {
      $.post("<?php echo base_url(); ?>index.php/transaksi/hapus_spk", {no_bukti_spk: row[1]}, function(data) {
        if (data == 1) {
          Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data SPK berhasil dihapus.',
                timer: 1500,
                showConfirmButton: false
              });
          loadData();
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Data SPK Gagal Dihapus'
          });
        }
      });
    }
  }

  
  function edit() {
    // 1. Ambil data baris yang dipilih dari DataTable
    var row = $('#table_spk').DataTable().row({selected: true}).data();
    
    // Periksa apakah ada baris yang dipilih
    if (!row) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: 'Mohon pilih satu data untuk dikoreksi.',
        });
        return; // Hentikan eksekusi jika tidak ada baris yang dipilih
    }
    
    // Ambil no_bukti_spk (diasumsikan berada di kolom indeks 1)
    var no_bukti_spk = row[1];

    // 2. Gunakan SweetAlert2 untuk konfirmasi
    Swal.fire({
        title: 'Koreksi Data',
        text: 'Anda Yakin Ingin Mengkoreksi Data Ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Koreksi!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        // 3. Lanjutkan jika pengguna menekan 'Ya, Koreksi!'
        if (result.isConfirmed) {
            $.ajax({
                data: "no_bukti_spk=" + no_bukti_spk, // Kirim data no_bukti_spk
                type: "POST",
                success: function(res) {
                  
                      // Jika server merespon sukses atau data siap dikoreksi
                      Swal.fire({
                          title: 'Berhasil!',
                          text: 'Data siap untuk dikoreksi.',
                          icon: 'success',
                          showConfirmButton: false,
                          timer: 1500
                      });
                      
                      // 4. Redirect ke halaman koreksi dengan parameter bukti yang benar
                      window.location.href =
                          '<?php echo base_url(); ?>index.php/transaksi/koreksi_spk?p=sukses&bukti=' +
                          no_bukti_spk; // Gunakan variabel no_bukti_spk yang sudah didefinisikan
                  
                },
                error: function(xhr, status, error) {
                     // Tangani error AJAX
                     Swal.fire({
                        title: 'Error Jaringan!',
                        text: 'Terjadi kesalahan saat menghubungi server: ' + error,
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>

        
