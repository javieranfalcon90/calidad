<div class="row g-3">      

    {{ Form::hidden('riesgo_id', $riesgo_id) }}

    <div class="col-12">
        <label class="form-label">Descripción*</label>
        {{ Form::textarea('descripcion', $valoracion->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Fecha*</label>
        {{ Form::text('fecha', $valoracion->fecha, ['class' => 'form-control datepick' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Efectividad*</label>
        {{ Form::select('efectividad_id', $efectividades, $valoracion->efectividad_id, ['class' => 'form-control select2' . ($errors->has('efectividad_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('efectividad_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    @if($valoracion->id)
        <div class="col-12">
            <label class="form-label">Conclusión </label> <span><i>Nota: Este campo será utilizado por los especialistas de calidad.</i></span>
            {{ Form::textarea('conclusion', $valoracion->conclusion, ['class' => 'form-control' . ($errors->has('conclusion') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
            {!! $errors->first('conclusion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    @endif


    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>

        <a href="{{ route('riesgos.show', $riesgo_id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
    </div>


</div>

<script type="text/javascript">
    $(function () {

        select_menu('riesgos')
      
    });
</script>