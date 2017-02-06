<!-- Starting Profile Settings -->
<div class="boxed-group col-xs-12 col-sm-7 col-md-9">
    <!-- Starting echo out the system feedback (error and success messages) -->
    <div class="panel panel-default">
        <div class="list-group-item active"><span class="menu-heading">Votre profil</span></div>
        <div class="list-group-item">
            <div class="row">
                <div class="boxed-group col-xs-12 col-sm-3 col-md-3">
                    <div class="form-group">
                        <div><label>Photo du profil</label></div>
                        <div class="be-upload clearfix">
                            <div class="img-responsive">
                                <img alt="img_{{ Auth::user()->getUsername() }}_profile" class="img-thumbnail" src="{{url( Auth::user()->getAvatar()) }}"  width="200">
                            </div>
                            <div>
                                <!-- avatar-upload -->
                                <form action="{{ route('profile.edit.avatar') }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="edit-pic">
                                        <button type="button" class="be-button-mdl" data-toggle="modal" data-target="#mdl-upload-avatar">
                                            <span class="be-button-icon"><i class="fa fa-camera-retro"></i> Changer de photo</span>
                                        </button>
                                    </div>
                                    <div class="modal colored-header colored-header-primary fade" id="mdl-upload-avatar" tabindex="-1" role="dialog" aria-labelledby="uploadAvatarLabel" data-backdrop="static">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" data-dismiss="modal" aria-label="Close" class="close" ><span aria-hidden="true" class="">&times;</span></button>
                                                    <h4 class="modal-title" id="uploadAvatarLabel">Upload an Avatar</h4>
                                                </div>
                                                <!-- /modal-content -->
                                                <div class="modal-body">
                                                    <label for="avatar_file">Select an avatar image from your hard-disk (will be scaled to 180x180 px, only .jpg currently):</label>
                                                    <input type="file" name="avatar_file" accept="image/jpg, image/JPG,image/JPEG, image/jpeg" />
                                                    <!-- max size 5 MB (as many people directly upload high res pictures from their digital cameras) -->
                                                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                                    <p>Vous pouvez également faire glisser une image à partir de votre ordinateur.</p>
                                                </div><!-- /modal-body -->
                                                <div class="modal-footer">
                                                    <button type="button" data-dismiss="modal" class="btn btn-default btn-space">Cancel</button>
                                                    <button type="submit" data-dismiss="modal" class="btn btn-primary btn-space">Upload image</button>
                                                </div><!-- /modal-footer -->
                                            </div> <!-- /modal-content -->
                                        </div><!-- /modal-dialog -->
                                    </div>
                                </form>
                                <!-- and avatar-upload -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="boxed-group col-xs-12 col-sm-7 col-md-9">
                    <div class="group-form">
                        <form accept-charset="UTF-8" action="#" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!-- Prenom -->
                                <div><label for="first_name">Prénom</label></div>
                                <input class="form-control" id="first_name" name="first_name" size="30" value="{{ Auth::user()->getFirstName() }}" type="text" readonly>
                            </div>
                            <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!-- Nom -->
                                <p></p>
                                <div><label for="last_name">Nom</label></div>
                                <input class="form-control" id="last_name" name="last_name" size="30" value="{{ Auth::user()->getLastName() }}" type="text" readonly>
                            </div>
                            <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!--- Public email -->
                                <p></p>
                                <div><label for="email">Public email</label></div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <select class="form-control" id="email" name="email">
                                            <option value="{{ Auth::user()->getEmail() }}" selected="selected">{{ Auth::user()->getEmail() }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
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
    </div>

    <div class="panel panel-default">
        <div class="list-group-item active"><span class="menu-heading">Mon profil</span></div>
        <div class="list-group-item">
            <div class="row">
                <div class="boxed-group col-xs-12 col-sm-12 col-md-12">
                    <div class="group-form">
                        <form accept-charset="UTF-8" action="#" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!-- About me -->
                                <div><label for="first_name">A propos de moi</label></div>
                                <textarea class="form-control" id="about"  name="about" cols="30" rows="10" value="{{ Auth::user()->profile->about}}" required readonly>{{ Auth::user()->profile->about }}</textarea>
                            </div>
                            <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!-- Location -->
                                <p></p>
                                <div><label for="last_name">Location</label></div>

                                <input class="form-control" id="location" name="location" size="30" value="{{ Auth::user()->profile->location }}" type="text" readonly>
                            </div>
                            <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!--- Save your information -->
                                <p></p>
                                <button type="submit" class="btn btn-primary">Enregistrez vos informations</button>
                                <p></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>