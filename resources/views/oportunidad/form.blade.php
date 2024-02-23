<div class="row g-3">   

    <div class="col-4">
        <label class="form-label">Código*</label>
        {{ Form::text('codigo', $oportunidad->codigo, ['class' => 'form-control' . ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-4">
        <label class="form-label">Fecha de Notificación*</label>
        {{ Form::text('fechanotificacion', $oportunidad->fechanotificacion, ['class' => 'form-control datepick' . ($errors->has('fechanotificacion') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fechanotificacion', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-4">
        <label class="form-label">Tipo de Fuente*</label>
        {{ Form::select('tipo', ['Riesgo' => 'Riesgo', 'Mejora' => 'Mejora'], $oportunidad->tipo, ['class' => 'select2 form-control' . ($errors->has('tipo') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('tipo', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    @role('ROLE_ADMIN')
    <div class="col-12">
        <label class="form-label">Proceso*</label>
        {{ Form::select('proceso_id', $procesos, $oportunidad->proceso_id, ['class' => 'form-control select2' . ($errors->has('proceso_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('proceso_id', '<div class="invalid-feedback">:message</div>') !!}
    </div> 
    @endrole
    
    


    <div class="col-12">
        <label class="form-label">Descripción*</label>
        {{ Form::textarea('descripcion', $oportunidad->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        <a href="{{ route('oportunidades.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
    </div>

</div>

  <script type="text/javascript">
    $(function () {

        select_menu('oportunidades')
      
    });
</script>