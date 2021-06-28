  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
          <span class="brand-text font-weight-light">Admin Panel</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="info" style="color:white">
                  <a href="#" class="d-block">{{ session('name') }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <li class="nav-item">
                      <a href="/" class="nav-link">
                          <i class="nav-icon far fa-image"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  @if(session('role_id') == 1)
                  <li class="nav-item">
                      <a href="/admin/report" class="nav-link">
                          <i class="nav-icon fas fa-columns"></i>
                          <p>
                              Reporting
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/admin/import" class="nav-link">
                          <i class="nav-icon fas fa-database"></i>
                          <p>
                              Import DB
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(session('role_id') == 2 || session('role_id') == 1  )
                  <li class="nav-item">
                      <a href="/admin/upload" class="nav-link">
                          <i class="nav-icon fas fa-upload"></i>
                          <p>
                              Upload
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/admin/map" class="nav-link">
                          <i class="nav-icon fas fa-map-signs"></i>
                          <p>
                              Map Simpan
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(session('role_id') == 3)
                  <li class="nav-item">
                      <a href="/admin/nasabah/indexing" class="nav-link">
                          <i class="nav-icon fas fa-upload"></i>
                          <p>
                              Indexing
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(session('role_id') == 4)
                  <li class="nav-item">
                      <a href="/admin/nasabah/qc" class="nav-link">
                          <i class="nav-icon fas fa-map-signs"></i>
                          <p>
                              QC
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(session('role_id') == 1)
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Pengaturan
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="/admin/user" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>User</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="/admin/log" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Log Aktifitas</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  @endif
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>