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
                    <h5 class="card-title text-center pb-0 fs-4">Cambiar contraseña</h5>
                    <p class="text-center small">Introduzca una nueva contraseña.</p>
                  </div>


                  <form class="row g-3" action="{{ route('password.update') }}" method="POST">
                    @csrf
                
                    <input type="hidden" value="{{ $request->route('token') }}" name="token"/> 

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="{{ $request->email }}">
                        
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                        
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label">Password Confirmación</label>
                        <input class="form-control" type="password" name="password_confirmation">
                        
                    </div>
     
                    <br>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Enviar</button>
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