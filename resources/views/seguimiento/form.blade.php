<div class="row g-3">
        
    {{ Form::hidden('accion_id', $accion_id) }}

    <div class="col-12">
        <label class="form-label">Seguimiento*</label>
        {{ Form::textarea('seguimiento', $seguimiento->seguimiento, ['class' => 'form-control' . ($errors->has('seguimiento') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
        {!! $errors->first('seguimiento', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Fecha*</label>
        {{ Form::text('fecha', $seguimiento->fecha, ['class' => 'form-control datepick' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Evidencia</label> - {{ $seguimiento->evidencia ? $seguimiento->evidencia : '-'}}
        {{ Form::file('evidencia', ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : '')]) }}
        {!! $errors->first('evidencia', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        <a href="{{ route('acciones.show', $accion_id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
    </div>


</div>

<script type="text/javascript">
    $(function () {


        if('{{ $accion->accionable_type }}' == "App\Models\Oportunidad"){
            select_menu('oportunidades');
        }else if('{{ $accion->accionable->analisisable_type }}' == "App\Models\Riesgo"){
            select_menu('riesgos');
        }else{
            select_menu('noconformidades');
        }
      
    });
</script>