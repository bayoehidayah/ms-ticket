<!-- /.login-logo -->
<div class="card card-outline card-default" id="loginForm">
    <div class="card-header text-center">
        <a href="<?= base_url("/") ?>" class="h1">MS Ticket</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="post" action="<?= base_url("auth/login") ?>" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <input id="username" type="text" class="form-control" name="username" required autocomplete="username" placeholder="Enter Username" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control"
                name="password" required autocomplete="current-password" placeholder="Enter Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
