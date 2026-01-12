<div class="page-sidebar">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li style="background: #e34724">
            <a style="font-size: 20px; text-align: center;font-weight: bold;" href="{{ route('cpanel.dashboard') }}">SCHOOL</a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="{{ asset('assets/images/users/avatar.jpg') }}" alt="John Doe" />
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="{{ asset('assets/images/users/avatar.jpg') }}" alt="John Doe" />
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{ Auth::user()->name }}</div>
                    <div class="profile-data-title">{{ Auth::user()->email }}</div>
                </div>
                <div class="profile-controls">
                    <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                    <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                </div>
            </div>
        </li>
        <li class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('cpanel.dashboard') }}"><span class="fa fa-desktop"></span><span class="xn-text">Dashboard</span></a>
        </li>

        <li class="{{ Request::segment(2) == 'admin' ? 'active' : '' }}">    
            <a href="{{ route('cpanel.admin') }}"><span class="fa fa-user"></span> <span class="xn-text">Admin</span></a>
        </li>

        <li class="{{ Request::segment(2) == 'school' ? 'active' : '' }}">    
            <a href="{{ route('cpanel.school') }}"><span class="fa fa-user"></span> <span class="xn-text">School</span></a>
        </li>

        <li class="xn-openable">
            <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Layouts</span></a>
            <ul>
                <li><a href="layout-boxed.html">List</a></li>
            </ul>
        </li>
    </ul>
    <!-- END X-NAVIGATION -->
</div>
