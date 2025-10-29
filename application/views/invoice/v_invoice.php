
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Tagihan Sewa kendaraan</h3>
  </div>
  <div class="card">
    <div class="card-header">
        <button class="btn btn-success" onclick="adddt()">Create</button>
      	<button class="btn btn-primary" onclick="viewdt()">View</button>
        <button class="btn btn-warning" onclick="editdt()">Edit</button>
        <button class="btn btn-danger" onclick="hapus()">Delete</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
          <div class="box-body" id="div_tabel_data"></div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Form</h4>
          </div>
          <div class="modal-body">
            <form id="formModal" onsubmit="return false">
              <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label>Bulan</label>
                  <select name="bulan" id="bulan" class="form-control form-select">
                      <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="01"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '01') echo "selected=\"selected\"";
                    }
                    ?>value="01">JANUARI
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="02"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '02') echo "selected=\"selected\"";
                    }
                    ?>value="02">FEBRUARI
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="03"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '03') echo "selected=\"selected\"";
                    }
                    ?>value="03">MARET
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="04"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '04') echo "selected=\"selected\"";
                    }
                    ?>value="04">APRIL
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="05"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '05') echo "selected=\"selected\"";
                    }
                    ?>value="05">MEI
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="06"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '06') echo "selected=\"selected\"";
                    }
                    ?>value="06">JUNI
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="07"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '07') echo "selected=\"selected\"";
                    }
                    ?>value="07">JULI
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="08"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '08') echo "selected=\"selected\"";
                    }
                    ?>value="08">AGUSTUS
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="09"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '09') echo "selected=\"selected\"";
                    }
                    ?>value="09">SEPTEMBER
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="10"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '10') echo "selected=\"selected\"";
                    }
                    ?>value="10">OKTOBER
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="11"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '11') echo "selected=\"selected\"";
                    }
                    ?>value="11">NOVEMBER
                    <option <?php 
                    if(isset($_GET['bulan'])){
                      if($_GET['bulan']=="12"){
                        echo "selected=\"selected\"";
                      }
                    }  
                    else{
                      if(date('m') == '12') echo "selected=\"selected\"";
                    }
                    ?>value="12">DESEMBER
                    
                  </select>
                </div>
                <div class="form-group">
                  <label>Tahun</label><br>
                  <?php
                  if(isset($_GET['tahun'])){
                    $tahun = $_GET['tahun'];
                  }  
                  else{
                    $_GET['tahun']=date('Y');
                  }
                  ?>
                  <input type="text" placeholder="TAHUN" name='tahun' id='tahun' class="form-control" required="true" onkeyup="uppercase(this)" value="<?php echo $_GET['tahun']?>">	
                </div>
                <div class="form-group">
                  <label>Vendor</label><br>
                  <select id="kd_vendor" name="kd_vendor" class="form-select form-control">
                    <option value="">-Pilih-</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>PPn</label><br>
                  <select id="jns_ppn" name="jns_ppn" class="form-select form-control">
                    <option value="Y">PPn</option>
                    <option value="N">Non PPn</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>PPh</label><br>
                  <select id="jns_pph" name="jns_pph" class="form-select form-control">
                    <option value="PPH23">PPh 23</option>
                    <option value="PPH4">PPh 4(2)</option>
                    <option value="N">Non PPh</option>
                  </select>
                </div>
              </div>
            </div>
            </form>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closemodal()">Batal</button>
          </div>
          
        </div>
      </div>
    </div>
    <!-- end modal -->

    <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Data Sewa</h4>
          </div>
          
          <div class="modal-body-view">
          </div>
         
        <div class="modal-footer"> <!-- modal footer -->
        <button class="btn btn-danger" aria-hidden="true" onclick="cetakdt()">Cetak Pdf</button>
        <button class="btn btn-secondary" data-dismiss="modal" onclick="closeviewmodal()" aria-hidden="true">Close</button>
        </div>
        </div> <!-- / .modal-content -->
      </div> <!-- / .modal-dialog -->
    </div>

    <!-- modal -->
    <div class="modal fade" id="myModalinvedit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow-lg">
          
          <!-- Header Biru -->
          <div class="modal-header bg-primary text-white">
            <h4 class="modal-title" id="myModalLabel">Form Edit</h4>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Body -->
          <div class="modal-body">
            <form id="formModalinvedit" onsubmit="return false">
              <div class="row">
                <div class="col-12">
                  <div class="form-group" style="display:none">
                    <label>Id</label><br>
                    <input type="text" id="idbi" name="idbi" class="form-control" readonly>
                  </div>

                  <div class="form-group mb-3">
                    <label>No. Bukti</label>
                    <input type="text" id="buktibi" name="buktibi" class="form-control" readonly>
                  </div>

                  <div class="form-group mb-3">
                    <label>Nopol</label>
                    <input type="text" id="nopol" name="nopol" class="form-control" readonly>
                  </div>

                  <div class="form-group mb-3">
                    <label>Harga Sewa</label>
                    <input type="text" id="jm_hrg" name="jm_hrg" class="form-control" onkeyup="harga('jm_hrg')" required>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Footer -->
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-primary" onclick="simpaninvedit()">
              <i class="fa fa-save me-1"></i> Simpan
            </button>
            <button type="button" class="btn btn-secondary" onclick="closemodaledit()" data-bs-dismiss="modal">
              <i class="fa fa-times me-1"></i> Batal
            </button>
          </div>

        </div>
      </div>
    </div>

    <!-- end modal -->

    <div class="modal fade" id="myModalinv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h4 class="modal-title" id="myModalLabel">Form</h4>
          </div>
          <div class="modal-body">
            <form id="formModalinv" onsubmit="return false">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label>No.Bukti</label><br>
                    <input type="text" id="nobuktibi" name="nobuktibi" class="form-control" readonly="true">
                  </div>
                  <div class="form-group">
                    <label>Vendor</label><br>
                    <input type="text" id="nmvendor" name="nmvendor" class="form-control" onkeyup="uppercase(this)" readonly>
                  </div>
                  <div class="form-group">
                    <label>No.Invoice</label><br>
                    <input type="text" id="no_invoice" name="no_invoice" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  
                </div>
                
              </div>
            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="simpaninv()">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closemodalinv()">Batal</button>
          </div>

        </div>
      </div>
    </div>
      
  </div>
</div>

<style>
  #viewmodal .modal-body {
    max-height: 70vh; /* biar tidak terlalu tinggi */
    overflow-y: auto; /* bisa di-scroll kalau datanya banyak */
  }
</style>

<script type="text/javascript">

  $(document).ready(function() {
    loadData();
  });

  function loadData() {
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/tagihan/tab_invoice',
			success: function (res) {
				$("#div_tabel_data").html(res);
			}
		});

	}

  function adddt() {
		$('#myModal').modal('show');
		$('#myModal').on('shown.bs.modal', function(){
		});
	}

  function closemodal() {
    $('#myModal').modal('hide');
  }

  function closeviewmodal() {
    $('#viewmodal').modal('hide');
  }

  function closemodaledit() {
    $('#myModalinvedit').modal('hide');
  }

  function closemodalinv() {
    $('#myModalinv').modal('hide');
  }
	
	$('#kd_vendor').select2({
    placeholder: 'Pilih Supplier',
    dropdownParent: $('#myModal'),
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_supplier_select2',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    },
    width: '100%'
  });

  function simpan() {
		data = $('#formModal').serialize();
		dataurl = "create_tagihan";
		$.ajax({
			url: dataurl,
			data: data,
			type: "POST",
			beforeSend: function () {
				if ($('[name="bulan"]').val() == '') {
					 Swal.fire({
              icon: 'warning',
              title: 'Oops...',
              text: 'Bulan harus diisi!'
            });
					  return false;
				}
				else if ($('[name="tahun"]').val() == '') {
					  Swal.fire({
              icon: 'warning',
              title: 'Oops...',
              text: 'Tahun harus diisi!'
            });
					  return false;
				}
				else if ($('[name="kd_vendor"]').val() == '') {
					  Swal.fire({
              icon: 'warning',
              title: 'Oops...',
              text: 'Vendor harus diisi!'
            });
					return false;
				}
			},
			success: function (res) {
				if (res == 1) {
					$('#myModal').modal('hide');
					 Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil disimpan.',
                timer: 1500,
                showConfirmButton: false
              });
          loadData();
				} else if (res == 2) {
					Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Data Tagihan Sudah Ada'
          });
				} 
			}
		});
	}
	

  function viewdt() {
 		$('#viewmodal').modal('show')
 		var row = $('#table_inv').DataTable().row({selected: true}).data();
 		var url = "<?php echo base_url(); ?>index.php/tagihan/v_databi";			
		no_bukti_bi = row[2];	
		$.post(url, {no_bukti_bi: no_bukti_bi} ,function(data) {				
			$(".modal-body-view").html(data).show();
		});
	}

  function hapus() {
    var row = $('#table_inv').DataTable().row({ selected: true }).data();

    if (!row) {
      Swal.fire({
        icon: 'warning',
        title: 'Peringatan',
        text: 'Pilih data yang akan dihapus!',
      });
      return;
    }

    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data tagihan ' + row[2] + ' akan dihapus!',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("<?php echo base_url(); ?>index.php/tagihan/hapus_tagihan", { no_bukti_bi: row[2] }, function (data) {
          if (data == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: 'Data tagihan berhasil dihapus.',
              timer: 1500,
              showConfirmButton: false
            });
            loadData();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal!',
              text: 'Data tagihan gagal dihapus.'
            });
          }
        });
      }
    });
  }

  function deletebi(idbi) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: 'Data ini akan dihapus secara permanen!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>index.php/tagihan/hapus_bidetail',
          type: 'POST',
          data: { id_bi: idbi },
          success: function (res) {
            if (res == 1) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil dihapus.',
                timer: 1500,
                showConfirmButton: false
              });
              viewdt();
              loadData(); // reload tampilan data
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Data gagal dihapus. Silakan coba lagi.'
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Terjadi Kesalahan!',
              text: 'Tidak dapat terhubung ke server.'
            });
          }
        });
      }
    });
  }


  function editbi(idbi)
	{
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/tagihan/ajaxdtbisewadtl",
			data: "id_bi="+idbi,
			type: "GET",
			dataType: "JSON",
			success: function (data)
			{
				$('[name="idbi"]').val(data.id_bi);
				$('[name="jm_hrg"]').val(data.hrg_satuan);
				$('[name="buktibi"]').val(data.no_bukti_bi);
        $('[name="nopol"]').val(data.nopol);
				$('#myModalinvedit').modal('show'); // show bootstrap modal when complete loaded
			}
		});
	}

  function simpaninvedit() {
    data = $('#formModalinvedit').serialize();
    dataurl = "simpan_bidetail_edit";
    $.ajax({
      url: dataurl,
      data: data,
      type: "POST",
      beforeSend: function () {
        if ($('[name="jm_hrg"]').val() == '') {
          Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Harga Sewa harus diisi!'
          });
          return false;
        }
      },
      success: function (res) {         
        if (res == 1) {
          $('#myModalinvedit').modal('hide');
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil disimpan.',
            timer: 1500,
            showConfirmButton: false
          });
          viewdt();
          loadData();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data gagal disimpan!'
          });
        }
      } 
    });
  }

  function editdt()
	{
		var row = $('#table_inv').DataTable().row({selected: true}).data();
		
		//Ajax Load data from ajax
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/tagihan/ajaxdtbisewa",
			data: "no_bukti_bi=" + row[2],
			type: "GET",
			dataType: "JSON",
			success: function (data)
			{
				$('[name="no_invoice"]').val(data.no_invoice);
				$('[name="nmvendor"]').val(data.nm_vendor);
				$('[name="nobuktibi"]').val(data.no_bukti_bi);
				$('#myModalinv').modal('show'); // show bootstrap modal when complete loaded
			}
		});
	}

  function simpaninv() {
    data = $('#formModalinv').serialize();
    dataurl = "simpan_bi_invoice";
    $.ajax({
      url: dataurl,
      data: data,
      type: "POST",
      beforeSend: function () {
        if ($('[name="no_invoice"]').val() == '') {
          Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'No.Invoice harus diisi!'
          });
          return false;
        }
      },
      success: function (res) {         
        if (res == 1) {
          $('#myModalinv').modal('hide');
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil disimpan.',
            timer: 1500,
            showConfirmButton: false
          });
          loadData();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Data gagal disimpan!'
          });
        }
      } 
    });
  }
  
  function cetakdt(){
		var row = $('#table_inv').DataTable().row({selected: true}).data();
		window.open("pdf_sewa?no_bukti_bi="+row[2]);
	}
</script>

        
