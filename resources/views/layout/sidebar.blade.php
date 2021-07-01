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
                  @if(in_array("reporting", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/report" class="nav-link">
                          <i class="nav-icon fas fa-columns"></i>
                          <p>
                              Reporting
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("performance", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/performance" class="nav-link">
                          <i class="nav-icon fas fa-columns"></i>
                          <p>
                              Kinerja User
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("import", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/import" class="nav-link">
                          <i class="nav-icon fas fa-database"></i>
                          <p>
                              Import DB
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("upload", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/upload" class="nav-link">
                          <i class="nav-icon fas fa-upload"></i>
                          <p>
                              Upload
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("map", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/map" class="nav-link">
                          <i class="nav-icon fas fa-map-signs"></i>
                          <p>
                              Map Simpan
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("indexing", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/nasabah/indexing" class="nav-link">
                          <i class="nav-icon fas fa-upload"></i>
                          <p>
                              Indexing
                          </p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("qc", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/nasabah/qc" class="nav-link">
                          <i class="nav-icon fas fa-map-signs"></i>
                          <p>
                              QC
                          </p>
                      </a>
                  </li>
                  @endif
                  <li class="nav-header">PENGATURAN</li>
                  @if(in_array("user", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/user" class="nav-link">
                          <i class="far fa-user nav-icon"></i>
                          <p>User Management</p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("role", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/role" class="nav-link">
                          <i class="fas fa-key nav-icon"></i>
                          <p>Role Management</p>
                      </a>
                  </li>
                  @endif
                  <li class="nav-item">
                      <a href="/admin/log" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Log Aktifitas</p>
                      </a>
                  </li>
                  @if(in_array("provinsi", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/provinsi" class="nav-link">
                          <i class="far fa-map nav-icon"></i>
                          <p>Provinsi</p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("kabupaten", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/kabupaten" class="nav-link">
                          <i class="far fa-map nav-icon"></i>
                          <p>Kabupaten / Kota</p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("kecamatan", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/kecamatan" class="nav-link">
                          <i class="far fa-map nav-icon"></i>
                          <p>Kecamatan</p>
                      </a>
                  </li>
                  @endif
                  @if(in_array("kelurahan", json_decode(session('permissions'))) || (session('role_id') == 1))
                  <li class="nav-item">
                      <a href="/admin/kelurahan" class="nav-link">
                          <i class="far fa-map nav-icon"></i>
                          <p>Kelurahan</p>
                      </a>
                  </li>
                  @endif
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>