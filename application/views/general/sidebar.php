<!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="../index.html" class="logo">
              <img
                src="<?php echo base_url(); ?>assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Menu</h4>
              </li>

              <!-- sidebar -->
              <?php
                $level = $this->session->userdata('role');
				
                $head  = "select a.id_head,b.judul_head,b.icon from m_akses a 
                left join m_menu_head b on a.id_head = b.id_head
                where a.level = '$level' AND b.judul_head is not null group by a.id_head order by b.sorting asc";
              
                $Dataheader = $this->db->query($head);
                $i=0;
				        $rows=array();
                foreach($Dataheader->result() as $h){
                  $rows[$i]['judul_head'] = $h->judul_head;
					        $rows[$i]['id_head'] = $h->id_head;
                  $rows[$i]['icon'] = $h->icon;
                  $judul = "judul_".$h->id_head;

                  echo "
                  <li class='nav-item submenu'>
                    <a data-bs-toggle='collapse' href='#".$judul."'>
                     <i class='".$h->icon."'></i>
                      <p>".$h->judul_head."</p>
                      <span class='caret'></span>
                    </a>
                    <div class='collapse' id='".$judul."'>
                      <ul class='nav nav-collapse'>";

                      $sub_menu = "select a.id_sub_menu,b.judul_sub,b.link,b.controller from m_akses a 
                        left join m_menu_sub b on a.id_sub_menu = b.id_sub where a.level = '$level' and a.id_head = '$h->id_head'";
                        $r_sub = $this->db->query($sub_menu);
                        $j=0;
                        $rows=array();
                        foreach($r_sub->result() as $d){
                          $rows[$j]['judul_sub'] = $d->judul_sub;
                          $rows[$j]['link'] = $d->link;
                          $rows[$j]['controller'] = $d->controller;
                        ?>	
                          <li>
                            <a href="<?php echo base_url(); ?>index.php/<?php echo $d->controller?>/<?php echo $d->link?>">
                              <span class="sub-item"><?php echo $d->judul_sub?></span>
                            </a>
                          </li>
                        <?php	
                        }
                      
                echo "</ul>
                    </div>
                  </li>
                  ";
                }
              ?>


            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->
      <div class="main-panel">

      <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="../index.html" class="logo">
                <img
                  src="<?php echo base_url(); ?>assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
           data-background-color="blue2">
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
                
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="<?php echo base_url(); ?>assets/img/profile.jpg"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
                    </div>
                    <span class="profile-username">
                      <span class="op-7"><?php echo $this->session->userdata('username')?></span>
                      <span class="fw-bold"><?php echo $this->session->userdata('nama')?></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            <img
                              src="<?php echo base_url(); ?>assets/img/profile.jpg"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>Hizrian</h4>
                            <p class="text-muted">hello@example.com</p>
                            <a
                              href="profile.html"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a
                            >
                          </div>
                        </div>
                      </li>
                      <li>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>index.php/welcome/logout">Logout</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

