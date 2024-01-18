<div class="row g-3">
        
    <div class="col-12">
        <label class="form-label">Username*</label> 
        {{ Form::text('name', $user->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-12">
        <label class="form-label">Email*</label> 
        {{ Form::text('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-12">
        <label class="form-label">Password*</label> 
        {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-12">
        <label class="form-label">Password Confirmation*</label> 
        {{ Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-12">
        <label class="form-label">Proceso</label> 
        {{ Form::select('proceso_id', $procesos, $user->proceso_id, ['class' => 'form-control select2' . ($errors->has('proceso_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('proceso_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-12">
        <label class="form-label">Roles</label>
        {{ Form::select('roles[]', $roles, $user->roles, ['class' => 'form-control multiple2' . ($errors->has('roles') ? ' is-invalid' : ''), 'placeholder' => '', 'multiple']) }}
        {!! $errors->first('roles', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
    </div>

</div>