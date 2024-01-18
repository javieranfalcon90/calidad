<div class="row g-3">

    <div class="col-6">
        <label class="form-label">Código*</label>
        {{ Form::text('codigo', $noconformidad->codigo, ['class' => 'form-control' . ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Fecha de Notificación*</label>
        {{ Form::text('fechanotificacion', $noconformidad->fechanotificacion, ['class' => 'form-control datepick' . ($errors->has('fechanotificacion') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fechanotificacion', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Fuente*</label>
        {{ Form::select('fuente_id',$fuentes, $noconformidad->fuente_id, ['class' => 'form-control select2' . ($errors->has('fuente_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fuente_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Requisito*</label>
        {{ Form::select('requisito_id',$requisitos, $noconformidad->requisito_id, ['class' => 'form-control select2' . ($errors->has('requisito_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('requisito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Clasificación*</label>
        {{ Form::select('clasificacion_id', $clasificaciones, $noconformidad->clasificacion_id, ['class' => 'form-control select2' . ($errors->has('clasificacion_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('clasificacion_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Proceso*</label>
        {{ Form::select('proceso_id', $procesos, $noconformidad->proceso_id, ['class' => 'form-control select2' . ($errors->has('proceso_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('proceso_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>    

    <div class="col-12">
        <label class="form-label">Descripción*</label>
        {{ Form::textarea('descripcion', $noconformidad->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        @if (!$noconformidad->id)
        <a href="{{ route('noconformidades.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @else
        <a href="{{ route('noconformidades.show', $noconformidad->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @endif
    </div>
</div>

    <script type="text/javascript">
    $(function () {

        select_menu('noconformidades')
      
    });
</script>