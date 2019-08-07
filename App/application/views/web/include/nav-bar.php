<!-- Sidebar -->
<?php 
$this->load->model('Menu_model');
$m=$this->Menu_model->MenuID();
?>
            <div id="sidebar-wrapper" class="waves-effect" data-simplebar>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="list-header"><?=$this->session->userdata("store_name")?> </li>
                            <li class="active-link"><a href="<?=base_url()?>Homepage"><i class="material-icons">dashboard</i>Dashboard</a></li>
                           
                                 <?php foreach($m as $menu) {?>
                                            
                           <li><a><i class="material-icons"><?= $menu['icon']?></i><?= $menu['menu_name']?><span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <?php 
                                            $var=$this->Menu_model->MenuSubM($menu['parent_id']);
                                            foreach($var as $submenu) { ?>
                                    <li><a href="<?= site_url($submenu['link']) ?>"><?= $submenu['submenu_name'] ?></a></li>
                                   
                                    <?php };?>  
                                </ul> 
                            </li>
                                <?php };?>        
                             
                          
                             <li class="list-divider"></li>
                            <li>
                                <a href="<?=base_url()?>User/password"><i class="fa fa-user-circle"></i> <span>Change Password</span>
                                    
                            </li>
                            <li class="list-divider"></li>
                            <li>
                                <a href="<?=base_url()?>/Auth/Logout"><i class="fa fa-indent"></i> <span>Logout</span>
                                    <span class="label pull-right orange">5+</span>   
                                </a>
                            </li>
                            <li class="side-last"></li>
                        </ul>
                        <!-- ./sidebar-nav -->
                    </div>
                    <!-- ./sidebar -->
                </div>
                <!-- ./sidebar-nav -->
            </div>
            <!-- ./sidebar-wrapper -->