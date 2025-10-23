
<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">SPK Sewa Kendaraan</h3>
  </div>
  <div class="card">
    <div class="card-body">
        <div class="row" id="headerdata">
            <div class="col-md-12 col-sm-12 col-xs-12">
            
              <table class="table">
                <tr>
                  <td>Tgl.Spk</td>
                  <td width="5">:</td>
                  <td><?php echo $this->func_global->dsql_tgl($Dataspk[0]->tgl_spk) ?></td>

                  <td>No.Bukti</td>
                  <td width="5">:</td>
                  <td><?php echo $Dataspk[0]->no_bukti_spk ?></td>
                </tr>
                <tr>
                  <td>Vendor</td>
                  <td width="5">:</td>
                  <td>[<?php echo $Dataspk[0]->kd_vendor ?>]<?php echo $Dataspk[0]->nm_vendor ?></td>

                  <td>No.SPK</td>
                  <td width="5">:</td>
                  <td><?php echo $Dataspk[0]->no_ref_spk ?></td>
                </tr>
                <tr>
                  <td>Tgl.Awal Kontrak</td>
                  <td width="5">:</td>
                  <td><?php echo $this->func_global->dsql_tgl($Dataspk[0]->tgl_awal) ?></td>

                  <td>Tgl.Akhir Kontrak</td>
                  <td width="5">:</td>
                  <td><?php echo $this->func_global->dsql_tgl($Dataspk[0]->tgl_akhir) ?></td>
                </tr>
              </table>
             

              <div class="alert alert-info" role="alert">
                <strong>Catatan:</strong> Silakan pilih data dari tabel di bawah untuk mengedit atau menghapus. Gunakan tombol "Simpan" untuk menyimpan perubahan.
              </div>
              
              <br/>

            <button class="btn btn-primary btn-sm" onclick="adddtl()">Add</button>
            <button class="btn btn-warning btn-sm" onclick="edit()"> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="deletedtl()"> Delete</button>
            <button class="btn btn-success btn-sm" onclick="savedata()"> Simpan</button>

            </div>
          </div>

          <div class="row" id="datatb">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="table-responsive">
              <div class="box-body" id="div_tabel_data_detail"></div>
              </div>
            </div>
          </div>

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
                        <div class="form-group" style="display:none">
                          <label>Id</label><br>
                          <input type="text" id="id_spk" name="id_spk" class="form-control" readonly>
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

  $(document).ready(function() {
    load_data_detail();
  });

  function load_data_detail(){
    var no_bukti_spk = "<?php echo $Dataspk[0]->no_bukti_spk ?>";
    $.ajax({
      url: "<?= site_url('transaksi/load_data_detail_spk') ?>",
      method: "POST",
      data: {no_bukti_spk: no_bukti_spk},
      success: function(data) {
        $('#div_tabel_data_detail').html(data);
        $('#table_data_detail').DataTable({
          "scrollX": true
        });
      }
    });
  }

  function clearmodal(){
    $('#kd_kendaraan').val('');
    $('#nm_kendaraan').val('');
    $('#nopol').val('');
    $('#hrg_satuan').val('');
  }

  function adddtl(){
    $('#myModalKendaraan').modal('show');
    clearmodal();
  }

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

  function simpankendaraan(){
    var no_bukti_spk = "<?php echo $Dataspk[0]->no_bukti_spk ?>";
    var kd_kendaraan = $('#kd_kendaraan').val();
    var nm_kendaraan = $('#nm_kendaraan').val();
    var nopol = $('#nopol').val();
    var hrg_satuan = $('#hrg_satuan').val();
    var id_spk = $('#id_spk').val();

    if(kd_kendaraan == ""){
      Swal.fire({
        icon: 'warning',
        title: 'Oops...',
        text: 'Kode Kendaraan harus diisi!'
      });
      return false;
    }

    $.ajax({
      url : '<?php echo base_url(); ?>index.php/transaksi/ins_data_detail_spk', 
      data : {
        no_bukti_spk: no_bukti_spk,
        kd_kendaraan: kd_kendaraan,         
        nm_kendaraan: nm_kendaraan,
        nopol: nopol,
        hrg_satuan: hrg_satuan,
        id_spk: id_spk
      },
      type : "POST",
      success : function(res) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data Berhasil disimpan',
          timer: 1500,
          showConfirmButton: false
        });
        closemodal();
        load_data_detail();
      }
    });
  }

  function deletedtl(){
    var row = $('#table_spk_detail').DataTable().row({selected: true}).data();
    if (!row) {
      alert('Pilih data yang akan dihapus!');
      return;
    }
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data kendaraan akan dihapus!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url : '<?php echo base_url(); ?>index.php/transaksi/hapus_data_detail_spk', 
          data : {
            id_spk: row[1],
          },
          type : "POST",
          success : function(res) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: 'Data kendaraan berhasil dihapus.',
              timer: 1500,  
              showConfirmButton: false
            });   
            load_data_detail();     
          }
        });
      }
    });
  }

  function edit(){
    var row = $('#table_spk_detail').DataTable().row({selected: true}).data();
    if (!row) {
      alert('Pilih data yang akan diedit!');
      return;
    }
    // Isi data modal dengan data dari baris yang dipilih
    // $('#kd_kendaraan').val(row[2]).trigger('change');
    // $('#nm_kendaraan').val(row[3]);
    $('#nopol').val(row[4]);
    $('#id_spk').val(row[1]);
    $('#hrg_satuan').val(row[5]);
    $("#kd_kendaraan").empty().append('<option value="'+row[2]+'">'+row[2]+"-"+row[3]+'</option>').val(row[2]).trigger('change');
    $('#myModalKendaraan').modal('show');
  }

  function savedata(){
    var no_bukti_spk = "<?php echo $Dataspk[0]->no_bukti_spk ?>";
    $.ajax({
      url : '<?php echo base_url(); ?>index.php/transaksi/simpan_koreksi_spk', 
      data : {
        no_bukti_spk: no_bukti_spk,
      },
      type : "POST",
      success : function(res) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data SPK berhasil disimpan.',
          timer: 1500,  
          showConfirmButton: false
        });   
        window.location.href = "<?php echo site_url('transaksi/viewspk') ?>";  
      }
    });
  }

</script>

 
