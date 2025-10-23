


        

<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">SPK Sewa Kendaraan</h3>
  </div>
  <div class="card">
    <div class="card-body">
        <form id="formModal" onsubmit="return false">
          <div class="row" id="headerform">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="form-group">
                <label>Tanggal</label><br>
                <input type="text" class="form-control" name="tgl_spk" id="tgl_spk" onchange="nobukti()">
              </div>
              <div class="form-group">
                <label>Supplier</label><br>
                <select id="kd_vendor" name="kd_vendor" class="form-select form-control">
                  <option value="">-Pilih-</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tgl.Awal Kontrak</label><br>
                <input type="text" id="tgl_awal" name="tgl_awal" class="form-control">
              </div>
              
              <div class="form-group">
                <button class="btn btn-info" onclick="addkendaraan()"><i class="icon-ok-sign icon-white"></i> Add kendaraan</button>
                <button class="btn btn-success" onclick="simpan()"><i class="icon-ok-sign icon-white"></i> Simpan</button>
                <button class="btn btn-danger" type="reset"><i class="icon-ok-sign icon-white"></i> Batal</button>
              </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label>No.Bukti</label><br>
                  <input type="text" class="form-control" name="no_bukti_spk" id="no_bukti_spk" readonly="true">
                </div>
                <div class="form-group">
                  <label>No.Spk</label><br>
                  <input type="text" id="no_ref_spk" name="no_ref_spk" class="form-control" onkeyup="uppercase(this)">
                </div>
                <div class="form-group">
                  <label>Tgl.Akhir Kontrak</label><br>
                  <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control">
                </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                <i>Data Kendaraan</i>
                <table id="datakendaraan" width="auto" class="table table-bordered table-striped">
                  <thead>
                  <tr style="background-color:#e9e9e9">
                    <th width="75" style="text-align: center">Kode Kendaraan</th>
                    <th width="65" style="text-align: center">Nama Kendaraan</th>
                    <th width="55" style="text-align: center">Nopol</th>
                    <th width="55" style="text-align: center">Harga Sewa</th>
                    <th width="30" style="text-align: center">Action</th>
                  </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                </div>
              </div>
          </div>
          
        </form>

        <!-- modal -->
        <div class="modal fade" id="myModalKendaraan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Form Kendaraan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <form id="formModalvendor" onsubmit="return false">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group">
                        <label>Kendaraan</label><br>
                        <select id="kd_kendaraan" name="kd_kendaraan" class="form-select form-control" style="width:100%" onchange="getdatakendaraan()">
                          <option value="">-Pilih-</option>
                        </select>
                      </div>
                      <div class="form-group" style="display: none;">
                        <label>Nm.Kendaraan</label><br>
                        <input type="text" id="nm_kendaraan" name="nm_kendaraan" class="form-control" onkeyup="uppercase(this)">
                      </div>
                      <div class="form-group">
                        <label>Nopol</label><br>
                        <input type="text" id="nopol" name="nopol" class="form-control" onkeyup="uppercase(this)">
                      </div>
                      <div class="form-group">
                        <label>Harga Sewa</label><br>
                        <input type="text" id="hrg_satuan" name="hrg_satuan" class="form-control" onkeyup="harga('hrg_satuan')">
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="simpankendaraan()">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closemodal()">Batal</button>
              </div>

            </div>
          </div>
        </div>
        <!-- end modal -->
          
    </div>
  </div>
</div>

<script type="text/javascript">
  
  $(document).ready(function(){
    $('#tgl_spk').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true,
    });

    $('#tgl_awal').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true,
    });

    $('#tgl_akhir').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true,
    });
  });

  function nobukti(){
      $.ajax({
        url : '<?php echo base_url(); ?>index.php/transaksi/get_bukti', 
        data : "tgl_spk="+$('#tgl_spk').val()+"&kd=SPK", 
        type : "POST",
      success : function(res) {
        $('#no_bukti_spk').val(res);
        $('.datepicker').hide();
      }
    });
	}

  
  $('#kd_vendor').select2({
    placeholder: 'Pilih Supplier',
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
    minimumInputLength: 2
  });

  $('#kd_kendaraan').select2({
    placeholder: 'Pilih Kendaraan',
    dropdownParent: $('#myModalKendaraan'),
    ajax: {
      url: '<?php echo base_url(); ?>index.php/combo/get_kendaraan_select2',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    },
  });

  function addkendaraan(){
    $('#myModalKendaraan').modal('show');
  }

  function getdatakendaraan(){
    var kd_kendaraan = $('#kd_kendaraan').val();
    $.ajax({
      url : '<?php echo base_url(); ?>index.php/transaksi/get_kendaraan', 
      data : "kd_kendaraan="+kd_kendaraan, 
      type : "POST",
      dataType: 'json',
      success : function(res) {
        $('#nm_kendaraan').val(res.nm_kendaraan);
      }
    });
  }

  function closemodal(){
    $('#kd_kendaraan').val('');
    $('#nm_kendaraan').val('');
    $('#nopol').val('');
    $('#hrg_satuan').val('');
    $('#myModalKendaraan').modal('hide');
  }

   function clearmodal(){
    $('#kd_kendaraan').val('');
    $('#nm_kendaraan').val('');
    $('#nopol').val('');
    $('#hrg_satuan').val('');
  }

  function simpankendaraan() {
    let kd_kendaraan = $("#kd_kendaraan").val().trim();
    let nm_kendaraan = $("#nm_kendaraan").val().trim();
    let nopol = $("#nopol").val().trim();
    let hrg_satuan = $("#hrg_satuan").val().trim();

    // Validasi input kosong
    if (kd_kendaraan === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Kode Kendaraan harus diisi!'
      });
      return false;
    }

    if (nopol === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Nopol harus diisi!'
      });
      return false;
    }

    if (hrg_satuan === '') {
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Harga Sewa harus diisi!'
      });
      return false;
    }

    // ✅ Cek duplikasi nopol
    let duplikat = false;
    $("#datakendaraan tbody tr").each(function() {
      let existingNopol = $(this).find("td:nth-child(3)").text().trim();
      if (existingNopol.toLowerCase() === nopol.toLowerCase()) {
        duplikat = true;
        return false; // keluar dari each()
      }
    });

    if (duplikat) {
      Swal.fire({
        icon: 'error',
        title: 'Duplikasi Data!',
        text: 'Nopol ' + nopol + ' sudah ada dalam daftar.'
      });
      return false;
    }

    // ✅ Tambahkan baris baru ke tabel
    $("#datakendaraan tbody").append(`
      <tr data-kendaraan="${kd_kendaraan}">
        <td>${kd_kendaraan}</td>
        <td>${nm_kendaraan}</td>
        <td>${nopol}</td>
        <td>${hrg_satuan}</td>
        <td align='center'>
          <button type="button" class="btn btn-icon btn-round btn-danger" onclick='deletelist("${nopol}", this)'>
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
    `);

    // ✅ Notifikasi sukses
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Kendaraan berhasil ditambahkan.',
      timer: 1500,
      showConfirmButton: false
    });

    clearmodal();
  }

  function deletelist(nopol, btn) {
    Swal.fire({
      title: 'Yakin hapus?',
      text: 'Apakah Anda yakin ingin menghapus kendaraan ' + nopol + '?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal',
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6'
    }).then((result) => {
      if (result.isConfirmed) {
        // Hapus baris tabel
        $(btn).closest('tr').remove();

        // Tampilkan notifikasi sukses
        Swal.fire({
          icon: 'success',
          title: 'Dihapus!',
          text: 'Kendaraan ' + nopol + ' berhasil dihapus.',
          timer: 1500,
          showConfirmButton: false
        });
      }
    });
  }

function simpan() {
    let formData = new FormData(); 
	
    $('#datakendaraan tbody tr').each(function (index) {
        let kd_kendaraan = $(this).attr("data-kendaraan");
        let nm_kendaraan = $(this).find('td:nth-child(2)').text();
        let nopol = $(this).find('td:nth-child(3)').text();
        let hrg_satuan = $(this).find('td:nth-child(4)').text();

        formData.append(`data_h[${index}]`, kd_kendaraan);
        formData.append(`data_i[${index}]`, nm_kendaraan);
        formData.append(`data_j[${index}]`, nopol);
        formData.append(`data_k[${index}]`, hrg_satuan);
    });

    // Tambahkan nilai lainnya
    formData.append("tgl_spk", $("#tgl_spk").val());
    formData.append("tgl_awal", $("#tgl_awal").val());
    formData.append("no_bukti_spk", $('#no_bukti_spk').val());
    formData.append("tgl_akhir", $('#tgl_akhir').val());
    formData.append("kd_vendor", $('#kd_vendor').val());
    formData.append("no_ref_spk", $('#no_ref_spk').val());
    formData.append("jumlahdatakendaraan", $('#datakendaraan tbody tr').length);

    // Validasi Form
    if ($('#tgl_spk').val() === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Tanggal SPK harus diisi!'
        });
        return false;
    }
    if ($('#kd_vendor').val() === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Vendor harus diisi!'
        });
        return false;
    }
    if ($('#tgl_awal').val() === '' || $('#tgl_akhir').val() === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Tanggal Awal & Akhir harus diisi!'
        });
        return false;
    }
    if ($('#datakendaraan tbody tr').length === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Data Kendaraan belum ditambahkan!'
        });
        return false;
    }

    // Kirim data dengan AJAX
    $.ajax({
        url: "ins_transaksi_spk",
        data: formData,
        type: "POST",
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#loading').show();
        },
        success: function (res) {
            if (res == 1) {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: 'Data SPK berhasil disimpan.',
                  timer: 1500,
                  showConfirmButton: false
                });
                location.reload();
            } else {
                alert(res);
            }
            $('#loading').hide();
        },
        error: function (xhr, status, error) {
            console.error("Terjadi Kesalahan:", error);
            $('#loading').hide();
        }
    });
}

</script>

 
