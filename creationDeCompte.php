                            <div id="ilnapasdecompte" class="col-md-6 col-xs-12">
                                <div class="gbox">
                                    <p class="mello">1</p>
                                    <button id="open-create-account-modal" data-toggle="modal"
                                        data-target="#create-account-modal">Je n'ai pas de compte</button>
                                    <div class="modal fade" id="create-account-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="create-account-modal-label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="create-account-modal-label">Créer un
                                                        compte
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo do_shortcode('[forminator_form id="301"]'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>