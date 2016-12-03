<div class="boxed-group col-xs-12 col-sm-7 col-md-9">
    <!-- echo out the system feedback (error and success messages) -->

    <div class="panel panel-default">
        <div class="list-group-item active">Changer le mot de passe</div>
        <div class="list-group-item">
            <form accept-charset="UTF-8" method="post" action="{{ route('profile.edit.password') }}" name="new_password" class="edit_user" id="change_password">
                <input type="hidden" name="username" value="{{ Auth::user()->getFirstNameOrUsername() }}" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <dl class="form password-confirmation-form">
                    <dt><label for="password_old">Ancien mot de passe</label></dt>
                    <dd class="input-group @if (isset($errors) and $errors->has('password_current')) has-error @endif">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password_old" class="form-control" name="password_current" required="required" type="password" autocomplete="off">
                    </dd>
                </dl>
                <dl class="form password-confirmation-form">
                    <dt><label for="password_new">Nouveau mot de passe</label></dt>
                    <dd class="input-group @if (isset($errors) and $errors->has('password_new')) has-error @endif">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input  id="password_new" class="form-control" name="password_new" required="required" type="password" autocomplete="off">
                    </dd>
                </dl>
                <dl class="form password-confirmation-form">
                    <dt><label for="password_confirm">Confirmer le nouveau mot de passe</label></dt>
                    <dd class="input-group @if (isset($errors) and $errors->has('password_confirm')) has-error @endif">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password_confirm" class="form-control" name="password_confirm" required="required" type="password" autocomplete="off">
                    </dd>
                </dl>
                <p>
                    <button class="btn" tabindex="2">Mettre à jour</button>
                </p>
            </form>
        </div>
    </div>

    <!-- Change username -->
    <div class="panel panel-default">
        <div class="list-group-item active"> Changer le nom d'utilisateu</div>
        <form accept-charset="UTF-8" action="{{ route('profile.edit.username') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="list-group-item">
                <div class="boxed-group-inner">
                    <p>Changer le nom d'utilisateur</p>
                    <p>
                        <a class="btn" href="#" rel="facebox" data-toggle="modal" data-target="#mdl-scale">Changer le nom d'utilisateur</a>
                    </p>
                    <div class="modal fade colored-header colored-header-primary" id="mdl-scale" tabindex="-1" role="dialog" aria-labelledby="mdl-scale-label" data-backdrop="static">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="mdl-scale-label">Changer le nom d'utilisateur</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Entrer un nouveau nom d'utilisateur</p>
                                    <div style="margin-bottom: 25px" class="input-group @if (isset($errors) and $errors->has('username')) has-error @endif">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input name="username" value="{{ old('username') }}" class="form-control" aria-label="Entrez un nouveau nom d'utilisateur" autofocus="" type="text">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">Annuler</button>
                                    <button type="submit" data-dismiss="modal" class="btn btn-primary">Changer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if($errors->any())
            <script>
                $(function() {
                    $('#mdl-scale').modal('show');
                });
            </script>
        @endif
    </div>

    <!-- Delete account -->
    <div class="panel panel-default">
        <div class="list-group-item active"> Supprimer mon compte</div>
        <div class="list-group-item">
            <div class="boxed-group-inner">
                <p>Une fois que votre compte supprimé, il n'y a pas de retour possible. Merci d'être certain de vouloir supprimer.</p>
                <p><a href="#" rel="facebox[.dangerzone]" class="btn btn-danger" tabindex="4" data-toggle="modal" data-target="#mdl-delete">Supprimer mon compte</a></p>
                <div class="modal fade colored-header colored-header-danger" id="mdl-delete" tabindex="-1" role="dialog" aria-labelledby="mdl-delete-label" data-backdrop="static">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="mdl-delete-label">Es-tu sûr de vouloir faire ça?</h4>
                            </div>
                            <div class="text-center">
                                <br>
                                <span class="modal-main-icon fa fa-info-circle"></span>
                                <h4>C'est extrêmement important.</h4>
                            </div>
                            <form accept-charset="UTF-8" action="{{ route('profile.delete.username', ['username' => Auth::user()->getUsername()]) }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="modal-body">
                                    <p>Nous allons <strong>supprimer immédiatement votre compte</strong>, ainsi que toutes vos recherches, favories, sur Medlib.</p>
                                    <p>Vous ne serez plus membre, et votre nom d'utilisateur sera disponible pour toute personne sur Medlib.</p>
                                    <p>Pour plus d'aide, lisez notre article "<a href="{{ route('helpers.deleting.account') }}">Suppression de votre compte d'utilisateur</a>".</p>
                                    <div class="form-group @if (isset($errors) and $errors->has('email')) has-error @endif">
                                        <label for="email" class="control-label">Entrez votre email :</label>
                                        <input id="email" name="email" class="form-control" required="" type="email" autocomplete="off">
                                    </div>
                                    <div class="form-group @if (isset($errors) and $errors->has('password')) has-error @endif">
                                        <label for="password" class="control-label">Confirmer votre mot de passe :</label>
                                        <input class="form-control" id="password" name="password" value="" type="password">
                                    </div>
                                    <div class="form-group @if (isset($errors) and $errors->has('g-recaptcha-response')) has-error @endif">
                                        {!! Recaptcha::render() !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </div>
                                @if($errors->any())
                                    <script>
                                        $(function() {
                                            $('#mdl-delete').modal('show');
                                        });
                                    </script>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
</div>