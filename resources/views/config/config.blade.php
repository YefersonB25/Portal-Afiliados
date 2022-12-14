@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="card">
                    <div class="row">
                        <form class="form-horizontal" method="POST"
                            action="{{ route('setting.update') }}" novalidate>
                            @csrf
                            <div class="col-lg-12">
                            {{-- <h3 class="text-center" >APLICACION</h3>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            @foreach ($errors->all() as $error)
                                            <span class="badge badge-danger">{{ $error }}</span>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="name">APP_NAME</strong>
                                                    <input id="APP_NAME"
                                                    type="text"
                                                    class="input100{{ $errors->has('APP_NAME') ? ' is-invalid' : '' }}"
                                                    name="APP_NAME"
                                                    tabindex="1" value="{{ $dataEnv['APP_NAME'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="email">APP_ENV</strong>
                                                    <input id="APP_ENV"
                                                    type="text"
                                                    class="input100{{ $errors->has('APP_ENV') ? ' is-invalid' : '' }}"
                                                    name="APP_ENV"
                                                    tabindex="1" value="{{ $dataEnv['APP_ENV'] }}"
                                                    autofocus>                                            </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="email">APP_KEY</strong>
                                                    <input id="APP_KEY"
                                                    type="text"
                                                    class="input100{{ $errors->has('APP_KEY') ? ' is-invalid' : '' }}"
                                                    name="APP_KEY"
                                                    tabindex="1" value="{{ $dataEnv['APP_KEY'] }}"
                                                    autofocus>                                             </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="password">APP_DEBUG</strong>
                                                    <input id="APP_DEBUG"
                                                    type="text"
                                                    class="input100{{ $errors->has('APP_DEBUG') ? ' is-invalid' : '' }}"
                                                    name="APP_DEBUG"
                                                    tabindex="1" value="{{ $dataEnv['APP_DEBUG'] }}"
                                                    autofocus>                                             </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">APP_URL</strong>
                                                    <input id="APP_URL"
                                                    type="text"
                                                    class="input100{{ $errors->has('APP_URL') ? ' is-invalid' : '' }}"
                                                    name="APP_URL"
                                                    tabindex="1" value="{{ $dataEnv['APP_URL'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            {{-- <h3 class="text-center" >LOG</h3>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            @foreach ($errors->all() as $error)
                                            <span class="badge badge-danger">{{ $error }}</span>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">LOG_CHANNEL</strong>
                                                    <input id="LOG_CHANNEL"
                                                    type="text"
                                                    class="input100{{ $errors->has('LOG_CHANNEL') ? ' is-invalid' : '' }}"
                                                    name="LOG_CHANNEL"
                                                    tabindex="1" value="{{ $dataEnv['LOG_CHANNEL'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">LOG_DEPRECATIONS_CHANNEL</strong>
                                                    <input id="LOG_DEPRECATIONS_CHANNEL"
                                                    type="text"
                                                    class="input100{{ $errors->has('LOG_DEPRECATIONS_CHANNEL') ? ' is-invalid' : '' }}"
                                                    name="LOG_DEPRECATIONS_CHANNEL"
                                                    tabindex="1" value="{{ $dataEnv['LOG_DEPRECATIONS_CHANNEL'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">LOG_LEVEL</strong>
                                                    <input id="LOG_LEVEL"
                                                    type="text"
                                                    class="input100{{ $errors->has('LOG_LEVEL') ? ' is-invalid' : '' }}"
                                                    name="LOG_LEVEL"
                                                    tabindex="1" value="{{ $dataEnv['LOG_LEVEL'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            <h3 class="text-center" >BASE DE DATOS</h3>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            @foreach ($errors->all() as $error)
                                            <span class="badge badge-danger">{{ $error }}</span>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">DB_CONNECTION</strong>
                                                    <input id="DB_CONNECTION"
                                                    type="text"
                                                    class="input100{{ $errors->has('DB_CONNECTION') ? ' is-invalid' : '' }}"
                                                    name="DB_CONNECTION"
                                                    tabindex="1" value="{{ $dataEnv['DB_CONNECTION'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">DB_HOST</strong>
                                                    <input id="DB_HOST"
                                                    type="text"
                                                    class="input100{{ $errors->has('DB_HOST') ? ' is-invalid' : '' }}"
                                                    name="DB_HOST"
                                                    tabindex="1" value="{{ $dataEnv['DB_HOST'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">DB_PORT</strong>
                                                    <input id="DB_PORT"
                                                    type="text"
                                                    class="input100{{ $errors->has('DB_PORT') ? ' is-invalid' : '' }}"
                                                    name="DB_PORT"
                                                    tabindex="1" value="{{ $dataEnv['DB_PORT'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">DB_DATABASE</strong>
                                                    <input id="DB_DATABASE"
                                                    type="text"
                                                    class="input100{{ $errors->has('DB_DATABASE') ? ' is-invalid' : '' }}"
                                                    name="DB_DATABASE"
                                                    tabindex="1" value="{{ $dataEnv['DB_DATABASE'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">DB_USERNAME</strong>
                                                    <input id="DB_USERNAME"
                                                    type="text"
                                                    class="input100{{ $errors->has('DB_USERNAME') ? ' is-invalid' : '' }}"
                                                    name="DB_USERNAME"
                                                    tabindex="1" value="{{ $dataEnv['DB_USERNAME'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">DB_PASSWORD</strong>
                                                    <input id="DB_PASSWORD"
                                                    type="text"
                                                    class="input100{{ $errors->has('DB_PASSWORD') ? ' is-invalid' : '' }}"
                                                    name="DB_PASSWORD"
                                                    tabindex="1" value="{{ $dataEnv['DB_PASSWORD'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <h3 class="text-center" >CORREO</h3>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            @foreach ($errors->all() as $error)
                                            <span class="badge badge-danger">{{ $error }}</span>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">MAIL_MAILER</strong>
                                                    <input id="MAIL_MAILER"
                                                    type="text"
                                                    class="input100{{ $errors->has('MAIL_MAILER') ? ' is-invalid' : '' }}"
                                                    name="MAIL_MAILER"
                                                    tabindex="1" value="{{ $dataEnv['MAIL_MAILER'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">MAIL_HOST</strong>
                                                    <input id="MAIL_HOST"
                                                    type="text"
                                                    class="input100{{ $errors->has('MAIL_HOST') ? ' is-invalid' : '' }}"
                                                    name="MAIL_HOST"
                                                    tabindex="1" value="{{ $dataEnv['MAIL_HOST'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">MAIL_PORT</strong>
                                                    <input id="MAIL_PORT"
                                                    type="text"
                                                    class="input100{{ $errors->has('MAIL_PORT') ? ' is-invalid' : '' }}"
                                                    name="MAIL_PORT"
                                                    tabindex="1" value="{{ $dataEnv['MAIL_PORT'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">MAIL_USERNAME</strong>
                                                    <input id="MAIL_USERNAME"
                                                    type="text"
                                                    class="input100{{ $errors->has('MAIL_USERNAME') ? ' is-invalid' : '' }}"
                                                    name="MAIL_USERNAME"
                                                    tabindex="1" value="{{ $dataEnv['MAIL_USERNAME'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">MAIL_PASSWORD</strong>
                                                    <input id="MAIL_PASSWORD"
                                                    type="text"
                                                    class="input100{{ $errors->has('MAIL_PASSWORD') ? ' is-invalid' : '' }}"
                                                    name="MAIL_PASSWORD"
                                                    tabindex="1" value="{{ $dataEnv['MAIL_PASSWORD'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">MAIL_ENCRYPTION</strong>
                                                    <input id="MAIL_ENCRYPTION"
                                                    type="text"
                                                    class="input100{{ $errors->has('MAIL_ENCRYPTION') ? ' is-invalid' : '' }}"
                                                    name="MAIL_ENCRYPTION"
                                                    tabindex="1" value="{{ $dataEnv['MAIL_ENCRYPTION'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <h3 class="text-center" >ORACLE OTM</h3>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            @foreach ($errors->all() as $error)
                                            <span class="badge badge-danger">{{ $error }}</span>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">ORACLE_OTM_SERVER</strong>
                                                    <input id="ORACLE_OTM_SERVER"
                                                    type="text"
                                                    class="input100{{ $errors->has('ORACLE_OTM_SERVER') ? ' is-invalid' : '' }}"
                                                    name="ORACLE_OTM_SERVER"
                                                    tabindex="1" value="{{ $dataEnv['ORACLE_OTM_SERVER'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">ORACLE_OTM_USERNAME</strong>
                                                    <input id="ORACLE_OTM_USERNAME"
                                                    type="text"
                                                    class="input100{{ $errors->has('ORACLE_OTM_USERNAME') ? ' is-invalid' : '' }}"
                                                    name="ORACLE_OTM_USERNAME"
                                                    tabindex="1" value="{{ $dataEnv['ORACLE_OTM_USERNAME'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">ORACLE_OTM_PASSWORD</strong>
                                                    <input id="ORACLE_OTM_PASSWORD"
                                                    type="text"
                                                    class="input100{{ $errors->has('ORACLE_OTM_PASSWORD') ? ' is-invalid' : '' }}"
                                                    name="ORACLE_OTM_PASSWORD"
                                                    tabindex="1" value="{{ $dataEnv['ORACLE_OTM_PASSWORD'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <h3 class="text-center" >ORACLE ERP</h3>
                                <div class="card">
                                    <div class="card-body">
                                        @if ($errors->any())
                                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            @foreach ($errors->all() as $error)
                                            <span class="badge badge-danger">{{ $error }}</span>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">ORACLE_ERP_SERVER</strong>
                                                    <input id="ORACLE_ERP_SERVER"
                                                    type="text"
                                                    class="input100{{ $errors->has('ORACLE_ERP_SERVER') ? ' is-invalid' : '' }}"
                                                    name="ORACLE_ERP_SERVER"
                                                    tabindex="1" value="{{ $dataEnv['ORACLE_ERP_SERVER'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">ORACLE_ERP_USERNAME</strong>
                                                    <input id="ORACLE_ERP_USERNAME"
                                                    type="text"
                                                    class="input100{{ $errors->has('ORACLE_ERP_USERNAME') ? ' is-invalid' : '' }}"
                                                    name="ORACLE_ERP_USERNAME"
                                                    tabindex="1" value="{{ $dataEnv['ORACLE_ERP_USERNAME'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <strong for="confirm-password">ORACLE_ERP_PASSWORD</strong>
                                                    <input id="ORACLE_ERP_PASSWORD"
                                                    type="text"
                                                    class="input100{{ $errors->has('ORACLE_ERP_PASSWORD') ? ' is-invalid' : '' }}"
                                                    name="ORACLE_ERP_PASSWORD"
                                                    tabindex="1" value="{{ $dataEnv['ORACLE_ERP_PASSWORD'] }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
