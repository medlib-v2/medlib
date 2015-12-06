<div class="boxed-group col-xs-12 col-sm-7 col-md-9">
    <!-- echo out the system feedback (error and success messages) -->

    <div class="panel panel-default">
        <div class="list-group-item active">Changer le mot de passe</div>
        <div class="list-group-item">
            <form accept-charset="UTF-8" method="post" action="{{ route('profile.edit.password') }}" name="new_password" class="edit_user" id="change_password">
                <input type="hidden" name="username" value="{{ Auth::user()->getFristNameOrUsername() }}" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <dl class="form password-confirmation-form">
                    <dt><label for="reset_input_passwor_old">Ancien mot de passe</label></dt>
                    <dd class="input-group @if ($errors->has('password_current')) has-error @endif">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="reset_input_passwor_old" class="form-control" name="password_current" required="required" type="password" autocomplete="off">
                    </dd>
                </dl>
                <dl class="form password-confirmation-form">
                    <dt><label for="reset_input_password_new">Nouveau mot de passe</label></dt>
                    <dd class="input-group @if ($errors->has('password_new')) has-error @endif">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input  id="reset_input_password_new" class="form-control" name="password_new" required="required" type="password" autocomplete="off">
                    </dd>
                </dl>
                <dl class="form password-confirmation-form">
                    <dt><label for="reset_input_password_repeat">Confirmer le nouveau mot de passe</label></dt>
                    <dd class="input-group @if ($errors->has('password_confirm')) has-error @endif">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="reset_input_password_repeat" class="form-control" name="password_confirm" required="required" type="password" autocomplete="off">
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
                    <p><a class="btn" href="#" rel="facebox" data-toggle="modal" data-target="#myModal">Changer le nom d'utilisateur</a></p>
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Changer le nom d'utilisateur</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Entrer un nouveau nom d'utilisateur</p>
                                    <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input name="username" value="{{ old('username') }}" class="form-control" aria-label="Enter a new username" autofocus="" type="text">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Change my username</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete account -->
    <div class="panel panel-default">
        <div class="list-group-item active"> Supprimer mon compte</div>
        <div class="list-group-item">
            <div class="boxed-group-inner">
                <p>Une fois que votre compte supprimé, il n'y a pas de retour possible. Merci d'être certain de vouloir supprimer.</p>
                <p><a href="#delete_account_confirmation" rel="facebox[.dangerzone]" class="btn btn-danger" tabindex="4" href="#" data-toggle="modal" data-target="#deleteModal">Supprimer mon compte</a></p>
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Are you sure you want to do this?</h4>
                                <br>
                                <div class="facebox-danger"><span class="octicon octicon-alert"></span>This is extremely important.</div>
                                <p>We will <strong>immediately delete all of your repositories (24)</strong>, along with all of your forks, wikis, issues, pull requests, and Medlib Pages sites.</p>
                                <p>You will no longer be billed, and your username will be available to anyone on Medlib.</p>
                                <p>For more help, read our article "<a href="{{ route('helpers.deleting.account') }}">Deleting your user account</a>".</p>
                            </div>
                            <form accept-charset="UTF-8" action="{{ route('profile.delete.username', ['username' => Auth::user()->getUsername()]) }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="modal-body">
                                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                                        <label for="user_emal" class="control-label">Enter your username:</label>
                                        <input id="user_emal" name="email" class="form-control" required="" type="email" autocomplete="off">
                                    </div>
                                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                                        <label for="user_password" class="control-label">Confirm your password:</label>
                                        <input class="form-control" id="user_password" name="password" value="" type="password">
                                    </div>
                                    <div class="form-group @if ($errors->has('g-recaptcha-response')) has-error @endif">
                                        {!! Recaptcha::render() !!}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Supprimer</button>
                                </div>
                                @if($errors->any())
                                    <script>
                                        $(function() {
                                            $('#deleteModal').modal('show');
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
</div>