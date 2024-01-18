<div class="row g-3">
        
    {{ Form::hidden('accionable_id', $accionable_id) }}
    {{ Form::hidden('accionable_type', $accionable_type) }}

    <div class="col-12">
        <label class="form-label">Acción*</label>
        {{ Form::textarea('accion', $accion->accion, ['class' => 'form-control' . ($errors->has('accion') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
        {!! $errors->first('accion', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Tipo de Acción*</label>
        {{ Form::select('tipo_id', $tipos, $accion->tipo_id, ['class' => 'form-control select2' . ($errors->has('tipo_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('tipo_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Responsable*</label>
        {{ Form::select('responsable_id', $responsables, $accion->responsable_id, ['class' => 'form-control select2' . ($errors->has('responsable_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('responsable_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Fecha de Cumplimiento*</label>
        {{ Form::text('fechacumplimiento', $accion->fechacumplimiento, ['class' => 'form-control datepick' . ($errors->has('fechacumplimiento') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fechacumplimiento', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Recurso</label>
        {{ Form::text('recurso', $accion->recurso, ['class' => 'form-control' . ($errors->has('recurso') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('recurso', '<div class="invalid-feedback">:message</div>') !!}
    </div>


    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        
        @if($accion->id)
            <a href="{{ route('acciones.show', $accion->id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @elseif($type == "App\Models\NoConformidad")
            <a href="{{ route('noconformidades.show', $toid) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @elseif($type == "App\Models\Riesgo")
            <a href="{{ route('riesgos.show', $toid) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @else
            <a href="{{ route('oportunidades.show', $accionable_id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @endif
    </div>

</div>

<script type="text/javascript">
    $(function () {


        if('{{ $accionable_type }}' == "App\Models\Oportunidad"){
            select_menu('oportunidades');
        }else if('{{ $type }}' == "App\Models\Riesgo"){
            select_menu('riesgos');
        }else{
            select_menu('noconformidades');
        }
      
    });
</script>