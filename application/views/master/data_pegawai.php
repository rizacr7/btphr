
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Data Pegawai</h3>
  </div>
  <div class="card">
    <div class="card-header">
        <!-- <button class="btn btn-warning btn-sm" onclick="edit()">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="hapus()">Delete</button> -->
        Data Pegawai
    </div>
    <div class="card-body">
        <div class="table-responsive">
          <table id="tblPegawai" class='table table-bordered dt-responsive table-head-bg-primary table-bordered-bd-primary mt-2' width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>No Pegawai</th>
                <th>Nama Pegawai</th>
                <th>Status Pegawai</th>
                <th>Jabatan</th>
                <th>Level</th>
                <th>Tgl Masuk</th>
                <th>Alamat</th>
                <th>No.KTP</th>
                <th>Jenis Kelamin</th>
                <th>Tmpt.Lahir</th>
                <th>Tgl.Lahir</th>
                <th>No. HP</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>

        <!-- modal -->
        <div class="modal fade" id="myModal" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Form Pegawai</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
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
                          <select name="kd_level_jab" id="kd_level_jab" class="form-control" style="width: 100%;">
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
                          <label>NPWP</label><br>
                          <input type="text" id="npwp" name="npwp" class="form-control" onkeyup="uppercase(this)">
                        </div>
                        <div class="form-group">
                          <label>Tgl.Kontrak</label><br>
                          <input type="text" id="tgl_kontrak" name="tgl_kontrak" class="form-control">
                        </div>
                        
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <label>Status Pegawai</label><br>
                          <select name="status_peg" id="status_peg" class="form-select form-control" style="width: 100%;">>
                            <option value="">--Pilih--</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>No.Pegawai</label><br>
                          <input type="text" id="no_peg" name="no_peg" class="form-control" onkeyup="uppercase(this)" readonly>
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
                          <label>Status Pajak (PTKP)</label><br>
                          <select name="status_pajak" id="status_pajak" class="form-select form-control" style="width: 100%;">
                            <option value="">--Pilih--</option>
                          </select>
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
</div>
<style>

  /* dropdown container (ketika open) */
.select2-container--open .select2-dropdown {
  z-index: 2147483647 !important; /* very large, use only for debugging */
}

/* container select2 agar tidak tersembunyi */
.select2-container {
  z-index: 99999 !important;
}


</style>
<script type="text/javascript">

 $(document).ready(function() {
  loadData();
});

function loadData() {
  $('#tblPegawai').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    order: [],
    ajax: {
      url: "<?= site_url('maspeg/get_data_pegawai') ?>", 
      type: "POST"
    },
    columnDefs: [
      { targets: [0,8], orderable: false, className: "text-center" }
    ],
  });
}

function hapusPegawai(no_peg) {
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data pegawai akan ditandai keluar.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '<?php echo base_url(); ?>index.php/maspeg/delete/'+ no_peg,
        type: "POST",
        dataType: "JSON",
        success: function (res) {
          if (res.status) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message,
              timer: 1500,
              showConfirmButton: false
            });
            $('#tblPegawai').DataTable().ajax.reload();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: res.message
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Tidak dapat menghapus data.'
          });
        }
      });
    }
  });
}

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
    dropdownParent: $("#myModal"),
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

  

  $('#status_pajak').select2({
    placeholder: 'Pilih Status PTKP',
    dropdownParent: $("#myModal"),
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

  function closemodal(){
    $('#myModal').modal('hide');
  }

  $('#myModal').on('shown.bs.modal', function () {
  
      $('#kd_level_jab').select2({
        placeholder: 'Pilih Level Jabatan',
        dropdownParent: $('#myModal'),
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
  });

function editPegawai(no_peg) {

    // Reset form sebelum mengisi data
    $('#formModal')[0].reset();

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/maspeg/get_maspeg/",   // GANTI SESUAI CONTROLLER
        type: "POST",
        data: { no_peg: no_peg },
        dataType: "JSON",
        success: function (res) {
            // Isi form dengan data dari server
            $('#tgl_masuk').val(res.tglmasuk);
            $('#na_peg').val(res.na_peg);
            $('#alamat').val(res.alamat);
            $('#tmpt_lahir').val(res.tmpt_lahir);
            $('#no_ktp').val(res.no_ktp);
            $('#pendidikan').val(res.pendidikan);
           
            $('#email').val(res.email);
            $('#bank').val(res.bank);
            $('#agama').val(res.agama);
            $('#tgl_kontrak').val(res.tglkontrak);
            $('#npwp').val(res.npwp);
            $('#no_peg').val(res.no_peg);
            $('#alamat_dms').val(res.alamat_dms);
            $('#tgl_lahir').val(res.tgllahir);
            $('#jns_kel').val(res.sex);
            $('#ket_pendidikan').val(res.ket_pendidikan);
            $('#no_hp').val(res.no_hp);
            $('#nm_ibu').val(res.nm_ibu);
            $('#no_rek').val(res.no_rek);
            $('#kawin').val(res.kawin);
            $('#tgl_akhir_kontrak').val(res.tglakhir);

            $("#status_pajak").empty().append('<option value="'+res.status_pajak+'">'+res.status_pajak+'</option>').val(res.status_pajak).trigger('change');
            $("#status_peg").empty().append('<option value="'+res.status_peg+'">'+res.status_peg+"|"+res.nm_statuspeg+'</option>').val(res.status_peg).trigger('change');
            $("#kd_level_jab").empty().append('<option value="'+res.kd_leveljab+'">'+res.nm_jab+"|"+res.level+'</option>').val(res.kd_leveljab).trigger('change');

            // Tampilkan modal
            $('#myModal').modal('show');
        },
        error: function () {
            alert("Gagal mengambil data pegawai");
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
      url: "<?= site_url('maspeg/updatepegawai') ?>", // ubah sesuai controller CI3
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

        
