<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
    <img src="/img/job.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Farm Managment</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="/img/adminlogo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">{{auth()->user()->userType->name }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
        </div>
    </div> --}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="/company" class="nav-link {{ Route::is('company.index') ? 'active' : '' }}">
                    <i  class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                    Dashboard

                    </p>
                </a>
            </li>
            {{-- <li class="nav-item  {{ Route::is('company.create.job') ? 'menu-is-opening menu-open' : '' }}
            {{ Route::is('company.jobs') ? 'menu-is-opening menu-open' : '' }}">
                <a href="#" class="nav-link {{ Route::is('company.create.job') ? 'active' : '' }} {{ Route::is('company.jobs') ? 'active' : '' }}">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Job
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/company/job/create" class="nav-link {{ Route::is('company.create.job') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/company/jobs" class="nav-link {{ Route::is('company.jobs') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jobs List</p>
                    </a>
                </li>
                </ul>
            </li> --}}
            <li class="nav-header">ATTENDANCE</li>
            <li class="nav-item">
                <a href="/attendance#/attendance" class="nav-link {{ Route::is('attendance.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-arrow-circle-down"></i>
                    <p>Attendance</p>
                </a>
            </li>
            <li class="nav-header">EMPLOYEES</li>
            <li class="nav-item">
                <a href="/employees#/employees" class="nav-link {{ Route::is('employee.index') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Employees</p>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="/payroll#/payrolls" class="nav-link {{ Route::is('payroll.index') ? 'active' : '' }}">
                <i class="fas fa-users nav-icon"></i>
                <p>Payroll</p>
                </a>
            </li> --}}
            <li class="nav-item  {{ Route::is('payroll.index') ? 'menu-is-opening menu-open' : '' }}
            {{ Route::is('company.jobs') ? 'menu-is-opening menu-open' : '' }}">
                <a href="#" class="nav-link {{ Route::is('payroll.index') ? 'active' : '' }} {{ Route::is('company.jobs') ? 'active' : '' }}">
                <i class="nav-icon fas fa-address-card"></i>
                <p>
                    PAYROLL
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/payroll#/payrolls" class="nav-link">
                    <i class="far fa-copy nav-icon"></i>
                    <p>Payroll</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/payroll#/generate" class="nav-link">
                    <i class="far fa-copy nav-icon"></i>
                    <p>Generate</p>
                    </a>
                </li>
                </ul>
            </li>
            <li class="nav-header">STOCKS</li>
            <li class="nav-item">
                <a href="/stocks#/stocks" class="nav-link {{ Route::is('warehouse.stock') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-box"></i>
                    <p>Stocks</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/items#/items" class="nav-link {{ Route::is('warehouse.item') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>Items</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/categories#/categories" class="nav-link {{ Route::is('warehouse.category') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-code-branch"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="nav-header">Deploy</li>
            {{-- <li class="nav-item">
                <a href="/company/profile" class="nav-link {{ Route::is('company.profile') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="/deploy-employee#/deploy-employees" class="nav-link {{ Route::is('deploy-employee.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Deploy Employee</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/deploy#/deploy" class="nav-link {{ Route::is('deploy.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-box-open"></i>
                    <p>Deploy Stocks</p>
                </a>
            </li>
            <li class="nav-header">PRODUCTION</li>
            {{-- <li class="nav-item">
                <a href="/company/profile" class="nav-link {{ Route::is('company.profile') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="/harvest#/harvest" class="nav-link {{ Route::is('harvest.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cart-arrow-down"></i>
                    <p>Harvest</p>
                </a>
            </li>
            <li class="nav-header">QR CODE</li>
            {{-- <li class="nav-item">
                <a href="/company/profile" class="nav-link {{ Route::is('company.profile') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="/qr-code#/codes" class="nav-link {{ Route::is('qr-code.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-qrcode"></i>
                    <p>QR Codes</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/scanner" target="_blank" class="nav-link">
                    <i class="nav-icon fas fa-qrcode"></i>
                    <p>Scanner</p>
                </a>
            </li>
            <li class="nav-header">Area</li>
            {{-- <li class="nav-item">
                <a href="/company/profile" class="nav-link {{ Route::is('company.profile') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="/areas#/areas" class="nav-link {{ Route::is('area.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-map-marker-alt"></i>
                    <p>Areas</p>
                </a>
            </li>
            <li class="nav-header">SETTINGS</li>
            {{-- <li class="nav-item">
                <a href="/company/profile" class="nav-link {{ Route::is('company.profile') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="iframe.html" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
