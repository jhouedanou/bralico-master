           <div id="ilauncompte" class="col-md-6 col-xs-12">
               <div class="gbox">
                   <p class="mello">2</p>
                   <h4>Vous avez déjà un compte ?</h4>
                   <ul>
                       <li>Connectez-vous pour mettre à jour votre CV et postuler aux offres.</li>
                       <li>Gérez vos candidatures et suivez leur avancement.</li>
                   </ul>
                   <button id="open-login-modal" data-toggle="modal" data-target="#login-modal">Se connecter</button>

                   <div class="modal fade" id="login-modal" tabindex="-1" role="dialog"
                       aria-labelledby="login-modal-label" aria-hidden="true">
                       <div class="modal-dialog" role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="login-modal-label">J'ai un compte</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>
                               <div class="modal-body">
                                   <?php
                                                echo 'Veuillez vous connecter pour postuler aux offres d\'emploi.';
                                                wp_login_form();
                                            ?>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

           </div>