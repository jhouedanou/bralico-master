        <div id="creationcompte" class="col-md-12">
            <div class="gbox">
                <?php 
                if(is_active_sidebar('creation-compte')){
                    dynamic_sidebar('creation-compte');
                }
                ?>
                <?php echo do_shortcode('[forminator_form id="301"]'); ?>
            </div>
        </div>