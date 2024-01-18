@extends('layouts.base')

@section('app')

<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="d-flex align-items-center w-auto">
                    <img src="{{ URL::asset('img/logo.png') }}" width="250" alt="" />
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                    <p class="text-center small">Introduzca su usuario y contraseña para acceder</p>
                  </div>

                  <form class="row g-3" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Username</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Entrar</button>
                    </div>

                

                    <div class="col-12">
                        <p class="small mb-0">Olvidó su contraseña?
                            <a href="{{ route('password.request') }}">Recuperar contraseña</a>
                        </p>
                    </div>

                </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
</main>

@endsection