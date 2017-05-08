<!-- info email -->
<div class="boxed-group col-xs-12 col-sm-7 col-md-9">
    <!-- echo out the system feedback (error and success messages) -->
    <div class="panel panel-default">
        <div class="list-group-item active"><span class="menu-heading"> E-mail</span></div>
        <div class="list-group-item">
            <div id="settings-emails" class="boxed-group-list standalone">
                <p class="clearfix settings-email primary ">
                    <p><strong>Actuel</strong></p>
                    <span class=""><strong>{{ Auth::user()->getEmail() }}</strong></span>
                </p>
            </div>
            <form accept-charset="UTF-8" action="{{ route('profile.edit.email') }}" id="loginform" class="form-horizontal" id="new_user_email" method="post" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="email">Entrer un email</label>
                <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input class="form-control" id="email" name="email" required="required" size="30" type="email" placeholder="email" />
                </div>
                <div style="margin-top:10px" class="btn-group">
                    <!-- Button -->
                    <div class="col-sm-12 controls" style="margin-bottom: 25px">
                        <button id="btn-login" type="submit" class="btn login-submit-button">
                            <span class="glyphicon glyphicon-user"> </span>  Changer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>