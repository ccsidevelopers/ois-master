<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo navbar-fixed-top">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CCSI</b></span>
        <!-- logo for regular state and mobile devices -->
        <img src="<?php echo e(asset('dist\img\ccsi-logo.png')); ?>">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top navbar-fixed-top">
        <!-- Sidebar toggle button-->
        <a href="#" id="SideBarClick" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span id="idnotifci"><span id="notifcount_fund_ci_header"></span></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <?php if(Auth::user()->hasRole('Credit Investigator')): ?>
                    <li class="dropdown messages-menu">
                        <a href="#" data-target="#modal_ci_fund" data-toggle="modal">
                            <span id="realtimefund" style="margin-top: 10px; font-size: medium"></span>
                        </a>
                    </li>
                    <li>
                        <a id="location_Check" href="#" >
                            <i class="glyphicon glyphicon-map-marker"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Messages: style can be found in dropdown.less-->

                

                    
                        
                        
                        
                    
                    
                        
                        
                            
                            
                                

                                

                                

                                
                                
                                    
                                        
                                            
                                        
                                        
                                            
                                            
                                        
                                        
                                    
                                
                                

                                
                                
                                    
                                        
                                            
                                        
                                        
                                            
                                            
                                        
                                        
                                    
                                
                                

                                
                                
                                    
                                        
                                            
                                        
                                        
                                            
                                            
                                        
                                        
                                    
                                
                                

                            
                        
                        
                    
                
                
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        
                        <span class="label label-warning" id="notifcount_notif"></span>
                        
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="notifcount_notif_label"></li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                <span class="menu" id="notifcount_notif_info"></span>

                            </ul>
                        </li>
                        <li class="footer"><a id="viewallhref">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                
                    
                        
                        
                        
                        
                    
                    
                        
                        
                            
                            
                                
                                    
                                        
                                            
                                            
                                        
                                        
                                            
                                                 
                                                
                                            
                                        
                                    
                                
                                
                                
                                    
                                        
                                            
                                            
                                        
                                        
                                            
                                                 
                                                
                                            
                                        
                                    
                                
                                
                                
                                    
                                        
                                            
                                            
                                        
                                        
                                            
                                                 
                                                
                                            
                                        
                                    
                                
                                
                                
                                    
                                        
                                            
                                            
                                        
                                        
                                            
                                                 
                                                
                                            
                                        
                                    
                                
                                
                            
                        
                        
                            
                        
                    
                
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo e(asset(Auth::user()->pix_path)); ?>" class="user-image">
                        <span class="hidden-xs"><?php echo e(Auth::user()->name); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo e(asset(Auth::user()->pix_path)); ?>" class="img-circle">

                            <p>
                                <?php echo e(Auth::user()->name); ?>

                                <small><?php echo e(Session::get('role')); ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Edit Display Icon</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo e(route('logout')); ?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                
                    
                
            </ul>
        </div>
    </nav>
    <input type="hidden" id="user-id" value="<?php echo e(Auth::user()->id); ?>">
</header>