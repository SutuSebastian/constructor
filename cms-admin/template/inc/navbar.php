<!-- Navbar top  -->
<nav class="navbar top-navbar navbar-expand fixed-top navbar-light bg-light p-1">
    <a class="website-title" href="./">
        <?php echo WEBSITE_TITLE; ?>
    </a>
    <div class="date_now"><?php echo date("j F Y - g:i A" ); ?></div>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-alt"></i>
                <span class="logged-user"><?php echo $user_info->fullname ?><span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="user-settings">
                    <i class="fas fa-wrench"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="engine/logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Log out
                </a>
            </div>
        </li>
    </ul>
</nav>

<!-- Navbar left -->
<nav class="sidebar">
    <ul class="nav flex-column">
        <li class="view-website">
            <a class="nav-link" title="View Website" target="_blank" href="../">
                <i class="fas fa-eye feather"></i>
                <span>View Website</span>
            </a>
        </li>
        <li class="nav-category">
            <small class="m-2">Summary</small>
        </li>
        <li>
            <a class="nav-link" title="Dashboard" href="dashboard">
                <i class="fas fa-home feather"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a class="nav-link" title="Statistics" href="statistics">
                <i class="far fa-chart-bar feather"></i>
                <span>Statistics</span>
            </a>
        </li>
        <li class="nav-category">
            <small class="m-2">Template</small>
        </li>
        <li>
            <a class="nav-link" title="Pages" href="pages">
                <i class="fas fa fa-copy feather"></i>
                <span>Pages</span>
            </a>
        </li>
        <li>
            <a class="nav-link" title="CSS & JS" href="css-js-files">
                <i class="fas fa-file-code feather"></i>
                <span>CSS & JS</span>
            </a>
        </li>
        <li>
            <a class="nav-link" title="Media files" href="media-files">
                <i class="fas fa-paperclip feather"></i>
                <span>Media Files</span>
            </a>
        </li>
        <li>
            <a class="nav-link" title="Header" href="header-edit">
                <i class="fas fa-window-maximize feather"></i>
                <span>Header</span>
            </a>
        </li>
        <li>
            <a class="nav-link" title="Footer" href="footer-edit">
                  <i class="fas fa-window-maximize fa-flip-vertical feather"></i>
                <span>Footer</span>
            </a>
        </li>
        <li>
            <a class="nav-link" title="CSS & JS Libraries" href="libraries">
                <i class="fas fa-link feather"></i>
                <span>Libraries</span>
            </a>
        </li>
        <li class="nav-category">
            <small class="m-2">Settings</small>
        </li>
        <li>
            <a class="nav-link" title="Website" href="website-settings">
                <i class="fas fa-laptop-code feather"></i>
                <span>Website</span>
            </a>
        </li>
        <li>
            <a class="nav-link" title="Users" href="user-settings">
                <i class="fas fa-users-cog feather"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-category">
            <small class="m-2">Documentation</small>
        </li>
        <li>
            <a class="nav-link" title="Global Variables" href="global-variables">
                <i class="fas fa-globe feather"></i>
                <span>Global Variables</span>
            </a>
        </li>
    </ul>
</nav>
