           <div id="ilauncompte" class="col">
                                <p>Connectez-vous pour accéder à nos offres d'emploi et postuler en ligne</p>
                                <button id="open-login-modal" data-toggle="modal" data-target="#login-modal">Se
                                    connecter</button>
                                <div class="modal fade" id="login-modal" tabindex="-1" role="dialog"
                                    aria-labelledby="login-modal-label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="login-modal-label">Se connecter</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
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