<div class="row g-3">   

    <div class="col-12">
        <label class="form-label">Nombre*</label>
        {{ Form::text('name', $permission->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-12">
        <label class="form-label">Grupo*</label>
        {{ Form::text('group', $permission->group, ['class' => 'form-control' . ($errors->has('group') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('group', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
    </div>

</div>

<script type="text/javascript">
    $(function () {

        select_menu('seguridad')
      
    });
</script>