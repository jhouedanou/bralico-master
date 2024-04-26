     <nav id="sidebar">
        <div class="sidebar-header">
                            <h3>Menu</h3>
                        </div>
                        <div id="sidebarmenu">
                        <?php
					    wp_nav_menu(array(
                            'container_id' => 'headermenuwrapper',
                            'menu_class' => 'headermenu',
                            'menu_id' => 'headermenu',
                            'theme_location' => 'Primarymenu',
                        ));
					?>
                        </div>
                    </nav>