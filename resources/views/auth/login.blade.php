<x-guest-layout>
 <div class="account-content">
        <div class="row login-wrapper m-0">
             <div class="col-lg-3 p-0">
                
            </div>
            <div class="col-lg-6 p-0">
                <div class="login-content">




                    <form action="{{ route('login') }}" method="POST">
                      @csrf
                        <div class="login-userset">
                            <div class="login-logo logo-normal">
                                <img src="{{ asset('build/img/logos/logo-ferzaor.png') }}" alt="img">
                            </div>
                            <a href="#" class="login-logo logo-white">
                                <img src="{{ asset('build/img/logos/logo-ferzaor.png') }}" alt="Img">
                            </a>
                            <div class="login-userheading">
                                <h3>Inicio de Sesión</h3>
                                <h4>Bienvenido a {{ config('app.name') }}.
                                </h4>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Correo electrónico</label>
                                <div class="input-group">


                                    <input type="text" class="form-control border-end-0
                                        @error('email') is-invalid @enderror" id="email" name="email"
                                        value="{{ old('movil') ?: old('email') }}" required autofocus>


                                    <span class="input-group-text border-start-0">
                                        <i class="ti ti-mail"></i>
                                    </span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                  @error('movil')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <div class="pass-group">
                                    <input type="password" name="password" id="password" class="pass-input form-control">
                                    <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                                </div>
                                  @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <div class="form-login authentication-check">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <span class="checkmarks"></span>Recuérdame
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a class="forgot-link" href="#">¿Has olvidado tu contraseña?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Iniciar Sesión</button>
                            </div>


                            <div class="form-sociallink">

                                <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                                    <p>Copyright &copy; {{ date('Y') }} {{ config('app.name') }}</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 p-0">
                
            </div>
        </div>
    </div>

</x-guest-layout>
