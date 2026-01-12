<!DOCTYPE html>
<html lang="en" class="body-full-height">

<head>
    <!-- META SECTION -->
    <title>Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/theme-default.css') }}">
    <!-- EOF CSS INCLUDE -->
</head>

<body>

    <div class="login-container">

        <div class="login-box animated fadeInDown">
            <div class="login-logo"></div>
            <div class="login-body">

                <form method="POST" action="{{ route('password.update') }}" class="form-horizontal">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email lấy từ link reset -->
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name="password" class="form-control" required
                                placeholder="Mật khẩu mới" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" name="password_confirmation" class="form-control" required
                                placeholder="Nhập lại mật khẩu" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-block">Đổi mật khẩu</button>
                    </div>

                </form>
            </div>
            <div class="login-footer">
                <div class="pull-left">
                    &copy; {{ date('Y') }} School
                </div>
            </div>
        </div>
    </div>

</body>

</html>
