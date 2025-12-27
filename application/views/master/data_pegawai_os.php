
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Master Data Pegawai OS</h3>
  </div>
  <div class="card">
    <div class="card-header">
      	<button class="btn btn-primary btn-sm" onclick="add()">Add</button>
        <button class="btn btn-warning btn-sm" onclick="edit()">Edit</button>
        <!-- <button class="btn btn-danger btn-sm" onclick="hapus()">Delete</button> -->
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
            <h4 class="modal-title" id="myModalLabel">Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <form id="formModal" onsubmit="return false">
              <div class="row" id="headerform">
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label>Tgl.Masuk</label><br>
                    <input type="text" id="tgl_masuk" name="tgl_masuk" class="form-control" onchange="getnopeg()">
                  </div>
                  <div class="form-group">
                    <label>Nama Pegawai</label><br>
                    <input type="text" id="na_peg" name="na_peg" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>Level Jabatan</label><br>
                    <select name="kd_level" id="kd_level" class="form-control">
                      <option value="">--Pilih--</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Alamat</label><br>
                    <textarea name="alamat" id="alamat" class="form-control" onkeyup="uppercase(this)"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Tempat Lahir</label><br>
                    <input type="text" id="tmpt_lahir" name="tmpt_lahir" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>No.KTP</label><br>
                    <input type="text" id="no_ktp" name="no_ktp" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>Pendidikan</label><br>
                    <select name="pendidikan" id="pendidikan" class="form-select form-control">
                      <option value="">--Pilih--</option>
                      <option value="SD">SD & SEDERAJAT</option>
                      <option value="SMP">SMP & SEDERAJAT</option>
                      <option value="SMA">SMA & SEDERAJAT</option>
                      <option value="D1">D1</option>
                      <option value="D2">D2</option>
                      <option value="D3">D3</option>
                      <option value="D4">D4</option>
                      <option value="S1">S1</option>
                      <option value="S2">S2</option>
                      <option value="S3">S3</option>
                    </select>
                  </div>
                 
                  <div class="form-group">
                    <label>Email</label><br>
                    <input type="text" id="email" name="email" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>Bank</label><br>
                    <select name="bank" id="bank" class="form-select form-control">
                      <option value="MANDIRI">MANDIRI</option>
                      <option value="BRI">BRI</option>
                      <option value="BSI">BSI</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Agama</label><br>
                    <select name="agama" id="agama" class="form-select form-control">
                      <option value="ISLAM">Islam</option>
                      <option value="KRISTEN">Kristen</option>
                      <option value="KATOLIK">Katolik</option>
                      <option value="HINDU">Hindu</option>
                      <option value="BUDHA">Budha</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tgl.Kontrak</label><br>
                    <input type="text" id="tgl_kontrak" name="tgl_kontrak" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>NPWP</label><br>
                    <input type="text" id="npwp" name="npwp" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group" style="display:none">
                    <label>Id</label><br>
                    <input type="text" id="id_pegawai" name="id_pegawai" class="form-control" onkeyup="uppercase(this)" readonly>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <label>No.Pegawai</label><br>
                    <input type="text" id="no_peg" name="no_peg" class="form-control" onkeyup="uppercase(this)" readonly>
                  </div>
                  <div class="form-group">
                    <label>Perusahaan</label><br>
                    <select name="kd_perusahaan" id="kd_perusahaan" class="form-select form-control">
                      <option value="">--Pilih--</option>
                      <option value="P02">SIC</option>
                      <option value="P03">GREEN</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Unit</label><br>
                    <select name="kd_unit" id="kd_unit" class="form-select form-control">
                      <option value="">--Pilih--</option>
                    </select>
                  </div>
                  <div class="form-group" style="display:none">
                    <label>Alamat Domisili</label><br>
                    <textarea name="alamat_dms" id="alamat_dms" class="form-control" onkeyup="uppercase(this)"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Tgl.Lahir</label><br>
                    <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Jenis Kelamin</label><br>
                    <select name="jns_kel" id="jns_kel" class="form-select form-control">
                      <option value="L">Laki-Laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Keterangan Pendidikan (Jurusan)</label><br>
                    <input type="text" id="ket_pendidikan" name="ket_pendidikan" class="form-control" onkeyup="uppercase(this)">
                  </div>
                
                  <div class="form-group">
                    <label>No.Hp</label><br>
                    <input type="text" id="no_hp" name="no_hp" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>Nama Ibu</label><br>
                    <input type="text" id="nm_ibu" name="nm_ibu" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>No.Rekening</label><br>
                    <input type="text" id="no_rek" name="no_rek" class="form-control" onkeyup="uppercase(this)">
                  </div>
                  <div class="form-group">
                    <label>Status Perkawinan</label><br>
                    <select name="kawin" id="kawin" class="form-select form-control">
                      <option value="TK">Tidak / Belum Kawin</option>
                      <option value="K">Kawin</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tgl.Akhir Kontrak</label><br>
                    <input type="text" id="tgl_akhir_kontrak" name="tgl_akhir_kontrak" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Status Pajak</label><br>
                    <select name="status_pajak" id="status_pajak" class="form-select form-control">
                      <option value="">--Pilih--</option>
                      <?php foreach ($status_pajak as $row): ?>
                          <option value="<?= $row->kode ?>">
                              <?= $row->keterangan ?>
                          </option>
                      <?php endforeach; ?>
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

  $("#tgl_masuk").datepicker({
        format:'dd-mm-yyyy',
        autoclose:true
  })	

  $("#tgl_lahir").datepicker({
        format:'dd-mm-yyyy',
        autoclose:true
  })	

  $("#tgl_kontrak").datepicker({
        format:'dd-mm-yyyy',
        autoclose:true
  })	

  $("#tgl_akhir_kontrak").datepicker({
        format:'dd-mm-yyyy',
        autoclose:true
  })	

  
  function getnopeg(){
		$.ajax({
	           url : '<?php echo base_url(); ?>index.php/maspeg/get_nopeg', 
	           data : "tgl_masuk="+$('#tgl_masuk').val()+"&status_peg=OS",
	           type : "POST",
			   beforeSend: function () {
				   if ($('[name="tgl_masuk"]').val() == '') {
						Swal.fire({
              icon: 'warning',
              title: 'Oops...',
              text: 'Tanggal Masuk Harus diisi!'
            });
            return false;
					}
			   },
			success : function(res) {
	        $('#no_peg').val(res);
			}
		});
	}

  $('#myModal').on('shown.bs.modal', function () {

      $("#kd_unit").select2({
          dropdownParent: $("#myModal"),
          width: '100%',
          ajax: {
            url: "<?php echo base_url(); ?>index.php/combo/combo_unit",
            dataType: 'json',
            delay: 500
          }
        });

        $("#kd_level").select2({
          dropdownParent: $("#myModal"),
          width: '100%',
          ajax: {
            url: "<?php echo base_url(); ?>index.php/combo/combo_level",
            dataType: 'json',
            delay: 500
          }
        });
        
  });
  

  $(document).ready(function() {
    loadData();
  });

  function loadData() {
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/maspegos/tab_pegawai_os',
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
    var table = $('#table_pegawai_os').DataTable();
    var selectedData = table.row({ selected: true }).data();

    if (!selectedData) {
      Swal.fire({
        icon: 'warning',
        title: 'Tidak ada data terpilih',
        text: 'Silakan pilih data pegawai yang akan diedit.',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
      return;
    }

    var id_pegawai = selectedData[1];

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/maspegos/get_pegawai_os',
      type: 'POST',
      data: { id_pegawai: id_pegawai },
      success: function(response) {
        var data = JSON.parse(response);

        // Isi form dengan data yang diperoleh
        $('#id_pegawai').val(data.id_pegawai);
        $('#no_peg').val(data.no_peg);
        $('#na_peg').val(data.na_peg);
        $('#tgl_masuk').val(data.tgl_msk);
        
        $('#alamat').val(data.alamat);
        $('#tmpt_lahir').val(data.tmpt_lahir);
        $('#no_ktp').val(data.no_ktp);
        $('#pendidikan').val(data.pendidikan);
        $('#email').val(data.email);
        $('#bank').val(data.bank);
        $('#agama').val(data.agama);
        $('#tgl_kontrak').val(data.tglkontrak);
        $('#tgl_akhir_kontrak').val(data.tglakhir);
        $('#npwp').val(data.npwp);
        $('#kd_perusahaan').val(data.kd_perusahaan).trigger('change');
        
        $('#tgl_lahir').val(data.tgl_lhr);
        $('#jns_kel').val(data.sex);
        $('#nm_ibu').val(data.nm_ibu);
        $('#no_rek').val(data.no_rek);
        $('#no_hp').val(data.no_hp);
        $('#status_pajak').val(data.status_pajak);
        $('#ket_pendidikan').val(data.ket_pendidikan);

        $("#kd_unit").empty().append('<option value="'+data.kd_unit+'">'+data.kd_unit+"|"+data.nm_unit+'</option>').val(data.kd_unit).trigger('change');

        $("#kd_level").empty().append('<option value="'+data.kd_level+'">'+data.kd_level+"|"+data.ket_level+'</option>').val(data.kd_level).trigger('change');
  }
    });

    $('#myModal').modal('show');
  }

  function simpan() {
    var data = $('#formModal').serialize();

    $.ajax({
      url: '<?php echo base_url(); ?>index.php/maspegos/simpan_data_os',
      type: 'POST',
      data: data,
      beforeSend: function () {
        // Validasi sederhana sebelum mengirim
        if ($('#na_peg').val() === '' || $('#kd_level').val() === '' || $('#kd_perusahaan').val() === '' || $('#tgl_masuk').val() === '') {
          Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Nama Pegawai, Level Jabatan, Perusahaan, dan Tanggal Masuk harus diisi!'
          });
          return false; // Batalkan pengiriman
        }
        else if($('#no_ktp').val() !== '' && $('#no_ktp').val().length != 16) {
          Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Nomor KTP harus 16 digit!'
          });
          return false; // Batalkan pengiriman
        }
        else if($('tgl_kontrak').val() !== '' && $('tgl_akhir_kontrak').val() === '') {
          Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Tanggal Akhir Kontrak harus diisi jika Tanggal Kontrak diisi!'
          });
          return false; // Batalkan pengiriman
        }
      },
      success: function(response) {
        if (response == 1) {
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

        
