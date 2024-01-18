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
                    <h5 class="card-title text-center pb-0 fs-4">Olvidó su contraseña?</h5>
                    <p class="text-center small">Introduzca su correo electrónico.</p>
                  </div>


                  <form class="row g-3" action="{{ route('password.request') }}" method="POST">
                    @csrf
                
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                            
                        @if(session('status'))
                            <div class="text-success">{{session('status')}}</div>
                        @endif

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