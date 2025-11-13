
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
    </div>
      
  </div>
</div>

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

  
</script>

        
