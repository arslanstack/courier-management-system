<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" style="width: 50px;" src="{{ asset('admin_assets/img/profile_small.jpg') }}" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">Welcome {{ ucwords(Auth::guard('admin')->user()->username) }}</span>
                        <span class="text-muted text-xs block">
                            {{ get_section_content('project', 'site_title') }}
                        </span>
                    </a>
                </div>
                <div class="logo-element">
                    {{ ucwords(Auth::guard('admin')->user()->username) }}
                    <span class="text-muted text-xs block">
                        {{ get_section_content('project', 'short_site_title') }}
                    </span>
                </div>
            </li>
            <li class="{{ Request::is('admin') ? 'active' : '' }} {{ Request::is('admin/admin') ? 'active' : '' }} {{ Request::is('admin/change_password') ? 'active' : '' }}">
                <a href="{{ url('admin') }}"><i class="fa-solid fa-gauge-high"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{ Request::is('admin/companies') ? 'active' : '' }} {{ Request::is('admin/companies/*') ? 'active' : '' }}">
                <a href="{{ url('admin/companies') }}"><i class="fa-solid fa-building"></i> <span class="nav-label">Companies</span></a>
            </li>
            <li class="{{ Request::is('admin/users') ? 'active' : '' }} {{ Request::is('admin/users/*') ? 'active' : '' }}">
                <a href="{{ url('admin/users') }}"><i class="fa-solid fa-users"></i> <span class="nav-label">Users</span></a>
            </li>
            <li class="{{ Request::is('admin/quote-requests') ? 'active' : '' }} {{ Request::is('admin/quote-requests/*') ? 'active' : '' }}">
                <a href="{{ url('admin/quote-requests') }}"><i class="fa-solid fa-building"></i> <span class="nav-label">Quote Requests</span></a>
            </li>
            <li class="{{ Request::is('admin/rfps') ? 'active' : '' }} {{ Request::is('admin/rfps/*') ? 'active' : '' }}">
                <a href="{{ url('admin/rfps') }}"><i class="fa-solid fa-comment-dots"></i> <span class="nav-label">Multiple Requests (RFP)</span></a>
            </li>
            <li class="{{ Request::is('admin/airports') ? 'active' : '' }} {{ Request::is('admin/airports/*') ? 'active' : '' }}">
                <a href="{{ url('admin/airports') }}"><i class="fa-solid fa-plane"></i> <span class="nav-label">Airports</span></a>
            </li>
            <li class="{{ Request::is('admin/warehouses') ? 'active' : '' }} {{ Request::is('admin/warehouses/*') ? 'active' : '' }}">
                <a href="{{ url('admin/warehouses') }}"><i class="fa-solid fa-truck"></i> <span class="nav-label">Warehouses</span></a>
            </li>
            <li class="{{ Request::is('admin/vehicle-posts') ? 'active' : '' }} {{ Request::is('admin/vehicle-posts/*') ? 'active' : '' }}">
                <a href="{{ url('admin/vehicle-posts') }}"><i class="fa-solid fa-car"></i> <span class="nav-label">Vehicle Posts</span></a>
            </li>
            <li class="{{ Request::is('admin/driver-ads') ? 'active' : '' }} {{ Request::is('admin/driver-ads/*') ? 'active' : '' }}">
                <a href="{{ url('admin/driver-ads') }}"><i class="fa-solid fa-drivers-license"></i> <span class="nav-label">Driver Ads</span></a>
            </li>
        </ul>
    </div>
</nav>