<!-- Starting Profile Settings -->
<div class="boxed-group col-xs-12 col-sm-7 col-md-9">
    <!-- Starting echo out the system feedback (error and success messages) -->
    <div class="panel panel-default">
        <div class="list-group-item active"><span class="menu-heading">Votre profil</span></div>
        <div class="list-group-item">
            <dl class="form edit-profile-avatar">
                <dt><label for="upload-profile-picture">Photo du profil</label></dt>
                <div class="avatar-upload-container clearfix">
                    <div class="col-md-3"><img alt="img_{{ Auth::user()->getFirstNameOrUsername() }}_here" class="img-thumbnail" src="{{ url('avatars/'. Auth::user()->getAvatar()) }}"  width="50%"></div>
                    <div class="avatar-upload">
                        <!-- avatar-upload -->
                        <form action="{{ route('profile.edit.avatar') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                                <i class="glyphicon glyphicon-open"></i>Changer de photo
                            </button>
                            <!-- Update an avatar -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Upload an Avatar</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label for="avatar_file">Select an avatar image from your hard-disk (will be scaled to 180x180 px, only .jpg currently):</label>
                                            <input type="file" name="avatar_file" accept="image/jpg, image/JPG,image/JPEG, image/jpeg" />
                                            <!-- max size 5 MB (as many people directly upload high res pictures from their digital cameras) -->
                                            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                            <p>Vous pouvez également faire glisser une image à partir de votre ordinateur.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Upload image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- and avatar-upload -->
                    </div>
                </div>
            </dl>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="list-group-item active"><span class="menu-heading">Votre profil</span></div>
        <div class="list-group-item">
            <div class="group-form">
                <form accept-charset="UTF-8" action="#" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group col-md-12"> <!-- Ici aussi -->
                        <div><label for="user_first_name">Prénom</label></div>
                        <input class="form-control" id="user_first_name" name="user_first_name" size="30" value="{{ Auth::user()->getFirstName() }}" type="text" readonly>
                    </div>
                    <div class="input-group col-md-12"> <!-- Nom -->
                        <p></p>
                        <div><label for="user_last_name">Nom</label></div>
                        <input class="form-control" id="user_last_name" name="user_last_name" size="30" value="{{ Auth::user()->getLastName() }}" type="text" readonly>
                    </div>
                    <div class="input-group col-md-12 col-xs-4"> <!--- Public email -->
                        <p></p>
                        <div><label for="user_email">Public email</label></div>
                        <div class="row">
                            <div class="col-sm-8 col-md-5">
                                <select class="col-sm-8 form-control" id="user_email" name="user_email">
                                    <option value="{{ Auth::user()->getEmail() }}" selected="selected">{{ Auth::user()->getEmail() }}</option>
                                </select>
                            </div>
                            <div class="col-sm-8 col-md-7">
                                <p class="">Vous pouvez modifier votre adress email dans vos <a href="{{ route('profile.show.email') }}">paramètres d'email personnel</a>.</p>
                            </div>
                        </div>
                        <p></p>
                        <button type="submit" class="btn btn-primary">Mise à jour du profil</button>
                        <p></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Ending echo out the system feedback (error and success messages) -->
</div>
<!-- Ending Profile Settings -->