


        

<div class="container">
<div class="page-inner">
  <div class="page-header">
    <h3 class="fw-bold mb-3">Dashboard</h3>
    
  </div>
   <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div
                  class="icon-big text-center icon-primary bubble-shadow-small"
                >
                  <i class="fas fa-car"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <?php
                  $query = $this->db->query("SELECT * FROM t_spk a 
                  LEFT JOIN t_spk_detail b ON a.no_bukti_spk = b.no_bukti_spk
                  WHERE a.flag_spk = 1 AND a.is_del = 0 AND b.flag_stop_sewa = 0");
                  $jumlah_kendaraan = $query->num_rows();
                ?>
                <div class="numbers">
                  <p class="card-category">Data Kendaraan</p>
                  <h4 class="card-title"><?php echo $jumlah_kendaraan?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
  
</div>

        
