<div class="row g-3">
        
    <div class="col-6">
        <label class="form-label">Código*</label>
        {{ Form::text('codigo', $riesgo->codigo, ['class' => 'form-control' . ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Fecha de Notificacion*</label>
        {{ Form::text('fechanotificacion', $riesgo->fechanotificacion, ['class' => 'form-control datepick' . ($errors->has('fechanotificacion') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fechanotificacion', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    @role('ROLE_ADMIN')
    <div class="col-12">
        <label class="form-label">Proceso*</label>
        {{ Form::select('proceso_id', $procesos, $riesgo->proceso_id, ['class' => 'form-control select2' . ($errors->has('proceso_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('proceso_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    @endrole

    <div class="col-12">
        <label class="form-label">Descripción*</label>
        {{ Form::textarea('descripcion', $riesgo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
    </div>


    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        @if (!$riesgo->id)
        <a href="{{ route('riesgos.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @else
        <a href="{{ route('riesgos.show', $riesgo->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @endif
    </div>

</div>


<script type="text/javascript">
    $(function () {

        select_menu('riesgos')
      
    });
</script>