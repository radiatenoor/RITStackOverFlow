<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
            </li>
            @if(auth('system_admin')->user()->role=='master-admin')
                <li><a><i class="fa fa-home"></i> System User <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ url('system/user/list') }}">List</a></li>
                        <li><a href="{{ url('new/system/user') }}">New</a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>

</div>
               