<!-- Sidebar Start -->
<aside class="left-sidebar">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="#" class="text-nowrap logo-img pt-4">
                <img src="<?= base_url()?>assets/img/logo.png" width="130" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= @$dash_active?>" href="<?= base_url()?>dashboard" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
 
                <?php 
                    if(
                        (($_SESSION['logged_user']['role']) == 'admin') || 
                        (($_SESSION['logged_user']['role']) == 'hr') ||
                        (($_SESSION['logged_user']['role']) == 'marketing') 
                    ){
                ?>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">MASTER</span>
                </li>
                <?php } ?>

                <?php if(($_SESSION['logged_user']['role']) == 'hr'){?>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= @$employee_active?>" href="<?= base_url()?>employe"  aria-expanded="false">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M15 19l2 2l4 -4" /></svg>
                        </div>
                        <span class="hide-menu">Employee</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= @$assign_active?>" href="<?= base_url()?>employe/assign_staff"  aria-expanded="false">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-user-plus"></i>
                        </div>
                        <span class="hide-menu">Assign Employee</span>
                    </a>
                </li>
                <?php } ?>

                <?php if(($_SESSION['logged_user']['role']) == 'marketing'){?>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= @$promotion_active?>" href="<?= base_url()?>promotion"  aria-expanded="false">
                        <div class="round-16 d-flex align-items-center justify-content-center">
                            <i class="ti ti-discount-2"></i>
                        </div>
                        <span class="hide-menu">Promotion</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-box"></i>
                        </span>
                        <span class="hide-menu">Setup Produk</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level <?= @$dpd_in?>">
                        <!-- <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                            <a href="<?= base_url()?>produk" class="sidebar-link <?= @$dpd_produk?>">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle fs-1"></i>
                                </div>
                                <span class="hide-menu">Produk</span>
                            </a>
                        </li> -->
                        <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                            <a href="<?= base_url()?>produk/additional" class="sidebar-link <?= @$dpd_additional?>">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle fs-1"></i>
                                </div>
                                <span class="hide-menu">Additional</span>
                            </a>
                        </li>
                        <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                            <a href="<?= base_url()?>produk/optional" class="sidebar-link <?= @$dpd_optional?>">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle fs-1"></i>
                                </div>
                                <span class="hide-menu">Optional</span>
                            </a>
                        </li>
                        <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                            <a href="<?= base_url()?>produk/satuan" class="sidebar-link <?= @$dpd_satuan?>">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle fs-1"></i>
                                </div>
                                <span class="hide-menu">Satuan</span>
                            </a>
                        </li>
                        <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                            <a href="<?= base_url()?>produk" class="sidebar-link <?= @$dpd_variant?>">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle fs-1"></i>
                                </div>
                                <span class="hide-menu">Produk</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php } ?>
             
                <?php if(($_SESSION['logged_user']['role']) == 'admin'){?>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow <?= @$master_active?>" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-settings"></i>
                        </span>
                        <span class="hide-menu">Setup Master</span>
                    </a>

                    <ul aria-expanded="false" class="collapse first-level <?= @$master_in?>">
                        <li class="sidebar-item">
                            <a href="<?= base_url()?>user" class="sidebar-link <?= @$dropdown_user?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-address-book"></i>
                                </div>
                                <span class="hide-menu">User</span>
                            </a>
                        
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url()?>member" class="sidebar-link <?= @$dropdown_member?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /></svg>
                                </div>
                                <span class="hide-menu">Member</span>
                            </a>
                        </li>
                        <!-- <li class="sidebar-item">
                            <a href="<?= base_url()?>employe" class="sidebar-link <?= @$dropdown_employe?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M15 19l2 2l4 -4" /></svg>
                                </div>
                                <span class="hide-menu">Employe</span>
                            </a>
                        </li> -->
                        <!-- <li class="sidebar-item">
                            <a href="<?= base_url()?>employe/assign_staff" class="sidebar-link <?= @$dropdown_assignstaff?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-user-plus"></i>
                                </div>
                                <span class="hide-menu">Assign Staff</span>
                            </a>
                        </li> -->
                        <li class="sidebar-item">
                            <a href="<?= base_url()?>outlet" class="sidebar-link <?= @$dropdown_outlet?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-building-store"></i>
                                </div>
                                <span class="hide-menu">Outlet</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link ms-3 has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-box"></i>
                                </span>
                                <span class="hide-menu">Setup Produk</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level <?= @$dpd_in?>">
                                <!-- <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                                    <a href="<?= base_url()?>produk" class="sidebar-link <?= @$dpd_produk?>">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle fs-1"></i>
                                        </div>
                                        <span class="hide-menu">Produk</span>
                                    </a>
                                </li> -->
                                <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                                    <a href="<?= base_url()?>produk/additional" class="sidebar-link <?= @$dpd_additional?>">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle fs-1"></i>
                                        </div>
                                        <span class="hide-menu">Additional</span>
                                    </a>
                                </li>
                                <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                                    <a href="<?= base_url()?>produk/optional" class="sidebar-link <?= @$dpd_optional?>">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle fs-1"></i>
                                        </div>
                                        <span class="hide-menu">Optional</span>
                                    </a>
                                </li>
                                <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                                    <a href="<?= base_url()?>produk/satuan" class="sidebar-link <?= @$dpd_satuan?>">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle fs-1"></i>
                                        </div>
                                        <span class="hide-menu">Satuan</span>
                                    </a>
                                </li>
                                <li class="ps-4 sidebar-item <?= @$dpd_active?>">
                                    <a href="<?= base_url()?>produk" class="sidebar-link <?= @$dpd_variant?>">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-circle fs-1"></i>
                                        </div>
                                        <span class="hide-menu">Produk</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url()?>promotion" class="sidebar-link <?= @$dropdown_promotion?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-discount-2"></i>
                                </div>
                                <span class="hide-menu">Promotion</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="<?= base_url()?>member/membership" class="sidebar-link <?= @$dropdown_membership?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                <i class="ti ti-credit-card"></i>
                                </div>
                                <span class="hide-menu">Membership</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= @$settings_active?>" href="<?= base_url()?>settings" aria-expanded="false">
                        <span>
                            <i class="ti ti-chart-candle"></i>
                        </span>
                        <span class="hide-menu">
                            Settings
                        </span>
                    </a>
                </li>
                <?php }?>

                <?php if(
                    (($_SESSION['logged_user']['role']) == 'admin') || 
                    (($_SESSION['logged_user']['role']) == 'finance') || 
                    (($_SESSION['logged_user']['role']) == 'kasir') 
                ){ ?>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Transactions</span>
                </li>
                
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow <?= @$history_active?>" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="hide-menu">History</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level <?= @$history_in?>">
                        <?php if(
                            (($_SESSION['logged_user']['role']) == 'admin') || 
                            (($_SESSION['logged_user']['role']) == 'finance')
                        ){ ?>
                        <li class="sidebar-item">
                            <a href="<?= base_url()?>history" class="sidebar-link <?= @$dropdown_htopup?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-cash"></i>
                                </div>
                                <span class="hide-menu">Topup</span>
                            </a>
                        </li>
                        <?php }?>
                        <li class="sidebar-item">
                            <a href="<?= base_url()?>history/order" class="sidebar-link <?= @$dropdown_horder?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-shopping-cart"></i>
                                </div>
                                <span class="hide-menu">Order</span>
                            </a>
                        </li>
                        <!-- <li class="sidebar-item">
                            <a href="<?= base_url()?>history/member" class="sidebar-link <?= @$dropdown_hmember?>">
                                <div class="round-16 ms-3 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-user-search"></i>
                                </div>
                                <span class="hide-menu">Members</span>
                            </a>
                        </li> -->
                    </ul>
                </li>

                <?php }?>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Reports</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link <?= @$rmembers_active?>" href="<?= base_url()?>report/members" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-search"></i>
                        </span>
                        <span class="hide-menu">
                            Report Members
                        </span>
                    </a>
                </li>


                <!-- <li class="sidebar-item">
                    <a class="sidebar-link  <?= @$historytopup_active?>" href="<?= base_url()?>topup/history" aria-expanded="false">
                        <span>
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="hide-menu">
                            Topup History
                        </span>
                    </a>
                </li> -->
                <li class="sidebar-item my-2 pb-5">
                    <a class="sidebar-link" href="<?= base_url()?>auth/logout" aria-expanded="false">
                        <span>
                            <i class="ti ti-logout"></i>
                        </span>
                        <span class="hide-menu">
                            Logout
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!--  Sidebar End -->

<!--  Main wrapper -->
<div class="body-wrapper">
    <!--  Header Start -->
    <header class="app-header" style="background-color: #000000; border-bottom: 1px solid #fff;">
        <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
            </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
            </li> -->
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item dropdown me-3">
                    <span id="clock" class="text-white"></span>
                </li>
                <li class="nav-item dropdown text-white">
                    <?= @$_SESSION['logged_user']['username']?>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= base_url()?>assets/img/user-2.jpg" alt="" width="35" height="35" class="rounded-circle">
                    </a>
                </li>
            </ul>
        </div>
        </nav>
    </header>
    <!--  Header End -->
