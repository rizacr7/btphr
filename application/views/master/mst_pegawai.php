
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
        <form id="formModal" onsubmit="return false">
          <div class="row" id="headerform">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Tgl.Masuk</label><br>
                <input type="text" id="tgl_masuk" name="tgl_masuk" class="form-control">
              </div>
              <div class="form-group">
                <label>Nama Pegawai</label><br>
                <input type="text" id="na_peg" name="na_peg" class="form-control" onkeyup="uppercase(this)">
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
                <label>Level Jabatan</label><br>
                <select name="kd_level_jab" id="kd_level_jab" class="form-control">
                  <option value="">--Pilih--</option>
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
             
              <div class="form-group">
                <button class="btn btn-success" onclick="simpan()"> Simpan</button>
                <button class="btn btn-danger" type="reset"> Batal</button>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Status Pegawai</label><br>
                <select name="status_peg" id="status_peg" class="form-select form-control" onchange="getnopeg()" style="height: 40px;">>
                  <option value="">--Pilih--</option>
                </select>
              </div>
              <div class="form-group">
                <label>No.Pegawai</label><br>
                <input type="text" id="no_peg" name="no_peg" class="form-control" onkeyup="uppercase(this)">
              </div>
              <div class="form-group">
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
                </select>
              </div>
            </div>
            
          </div>
        </form>
    </div>
      
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

  $('#status_peg').select2({
    placeholder: 'Pilih Status Pegawai',
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_statuspeg_select2',
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

  $('#kd_level_jab').select2({
    placeholder: 'Pilih Status Pegawai',
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_leveljab_select2',
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

  $('#status_pajak').select2({
    placeholder: 'Pilih Status PTKP',
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_ptkp_select2',
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

  function getnopeg(){
		$.ajax({
	           url : '<?php echo base_url(); ?>index.php/maspeg/get_nopeg', 
	           data : "tgl_masuk="+$('#tgl_masuk').val()+"&status_peg="+$('#status_peg option:selected').val(),
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

  function simpan() {
    const form = document.getElementById('formModal');
    const inputs = form.querySelectorAll('input, select, textarea');
    const optional = ['email']; // hanya email yang boleh kosong

    let isValid = true;
    let message = "";

    // Validasi frontend
    for (let el of inputs) {
      const id = el.id;
      const value = el.value.trim();

      if (optional.includes(id)) continue;

      if (value === "") {
        isValid = false;
        message = `Kolom <b>${id.replace(/_/g, ' ')}</b> wajib diisi.`;
        el.focus();
        break;
      }

      if ((id === 'no_ktp' || id === 'npwp') && value !== "" && value.length !== 16) {
        isValid = false;
        message = `Kolom <b>${id.replace(/_/g, ' ')}</b> harus 16 digit.`;
        el.focus();
        break;
      }
    }

    if (!isValid) {
      Swal.fire({
        icon: 'warning',
        title: 'Validasi Gagal',
        html: message,
        confirmButtonColor: '#3085d6'
      });
      return false;
    }

    // Kirim ke backend CI3
    $.ajax({
      url: "<?= site_url('maspeg/simpanpegawai') ?>", // ubah sesuai controller CI3
      type: "POST",
      data: $("#formModal").serialize(),
      dataType: "json",
      success: function(response) {
        if (response.status === true) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data pegawai berhasil disimpan.',
            showConfirmButton: false,
            timer: 1500
          });
          $("#formModal")[0].reset();
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal Menyimpan',
            text: response.message,
            confirmButtonColor: '#d33'
          });
        }
      },
      error: function(xhr, status, error) {
        Swal.fire({
          icon: 'error',
          title: 'Terjadi Kesalahan',
          text: 'Gagal menghubungi server: ' + error,
          confirmButtonColor: '#d33'
        });
      }
    });
  }


</script>

        
