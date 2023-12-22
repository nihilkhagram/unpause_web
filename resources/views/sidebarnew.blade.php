<?php $baseurl = URL::to('/'); ?>
<body class="main" >
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="Rubick Tailwind HTML Admin Template" class="w-6" src="<?php echo $baseurl; ?>/assets/images/logo.svg">
                </a>
                <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            </div>
            <ul class="border-t border-theme-29 py-5 hidden">
                <li>
                    <a href="<?php echo $baseurl; ?>" class="menu {{ Request::segment(1) === '' ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title"> Dashboard  </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="menu {{ Request::segment(1) === 'test' ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="box"></i> </div>
                        <div class="menu__title"> Test <i data-feather="chevron-down" class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="">
                        <li>
                            <a href="<?php echo $baseurl; ?>/test" class="menu {{ Request::segment(1) === 'test' ? 'menu--active' : '' }}">
                                <div class="menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="menu__title"> Test List  </div >
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $baseurl; ?>/test/create" class="menu {{ Request::segment(1) === 'test' ? 'menu--active' : '' }}">
                                <div class="menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="menu__title"> Add Test </div>
                            </a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="<?php echo $baseurl; ?>/reports" class="menu {{ Request::segment(1) === 'reports' ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="file"></i> </div>
                        <div class="menu__title"> Report List  </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $baseurl; ?>/users" class="menu {{ Request::segment(1) === 'users' ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="user"></i> </div>
                        <div class="menu__title"> Users List </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $baseurl; ?>/symptom" class="menu {{ Request::segment(1) === 'symptom' ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="clipboard"></i> </div>
                        <div class="menu__title"> Symptom List  </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $baseurl; ?>/menopause" class="menu {{ Request::segment(1) === 'menopause' ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="file"></i> </div>
                        <div class="menu__title"> Menopause List </div>
                    </a>
                </li>
              
				            </ul>
        </div>
        <!-- END: Mobile Menu -->
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            <nav class="side-nav">
                <a href="" class="intro-x flex items-center pl-5 pt-4">
                    <img alt="LiftERP Tailwind HTML Admin Template" class="w-6" src="<?php echo $baseurl; ?>/assets/images/logo.svg">
                    <span class="hidden xl:block text-white text-lg ml-3"> RU <span class="font-medium">Medical</span> </span>
                </a>
                <div class="side-nav__devider my-6"></div>
                <ul>
                   
                   
			                    <li>
                                    <a href="<?php echo $baseurl; ?>" class="side-menu {{ Request::segment(1) == '' ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i class="fa fa-home"></i> </div>
                                        <div class="side-menu__title">
                                            Dashboard
                                        </div>
                                    </a>
                                </li>
                     <li> 
                        <a href="javascript:;" class="side-menu {{ Request::segment(1) === 'test' ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Test  <i data-feather="chevron-down" class="side-menu__sub-icon "></i> </div>
                        </a>
                        <ul class="{{ Request::segment(1) === 'test' ? 'side-menu__sub-open' : '' }}">
                            <li>
                                <a href="<?php echo $baseurl; ?>/test" class="side-menu {{ Request::segment(1) === 'test' ? 'side-menu--active' : '' }}">
                                   <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Test List </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $baseurl; ?>/test/create" class="side-menu {{ Request::segment(1) === 'test' & Request::segment(2) === 'create' ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                    <div class="side-menu__title"> Add Test List </div>
                                </a>
                            </li>
                        </ul>
                    </li> 
                   
                                <li>
                                    <a href="<?php echo $baseurl; ?>/reports" class="side-menu {{ Request::segment(1) == 'reports' ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="file"></i> </div>
                                        <div class="side-menu__title">
                                        Report List
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $baseurl; ?>/users" class="side-menu {{ Request::segment(1) == 'users' ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                                        <div class="side-menu__title">
                                        Users List
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $baseurl; ?>/symptom" class="side-menu {{ Request::segment(1) == 'symptom' ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="clipboard"></i> </div>
                                        <div class="side-menu__title">
                                        Symptom List
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $baseurl; ?>/menopause" class="side-menu {{ Request::segment(1) == 'menopause' ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="file"></i> </div>
                                        <div class="side-menu__title">
                                        Menopause List
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $baseurl; ?>/orders" class="side-menu {{ Request::segment(1) == 'orders' ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="file"></i> </div>
                                        <div class="side-menu__title">
                                        Order List
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $baseurl; ?>/otas" class="side-menu {{ Request::segment(1) == 'otas' ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="file"></i> </div>
                                        <div class="side-menu__title">
                                        OTA files
                                        </div>
                                    </a>
                                </li>
                 
                   </ul>
                   
                    
            </nav>
            <!-- END: Side Menu -->