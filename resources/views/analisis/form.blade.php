<div class="row g-3">
        
    {{ Form::hidden('analisisable_id', $analisisable_id) }}
    {{ Form::hidden('analisisable_type', $analisisable_type) }}

    <div class="col-12">
        <label class="form-label">Causa*</label>
        {{ Form::textarea('causa', $analisis->causa, ['class' => 'form-control' . ($errors->has('causa') ? ' is-invalid' : ''), 'placeholder' => '', 'rows' => 4]) }}
        {!! $errors->first('causa', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Fecha*</label>
        {{ Form::text('fecha', $analisis->fecha, ['class' => 'form-control datepick' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-6">
        <label class="form-label">Participantes*</label>
        {{ Form::text('participantes', $analisis->participantes, ['class' => 'form-control' . ($errors->has('participantes') ? ' is-invalid' : ''), 'placeholder' => '']) }}
        {!! $errors->first('participantes', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    @if ($analisisable_type == 'App\Models\Riesgo')
        <div class="col-6">
            <label class="form-label">Manifestaciones Negativas*</label>
            {{ Form::text('manifestacionesnegativas', $analisis->manifestacionesnegativas, ['class' => 'form-control' . ($errors->has('manifestacionesnegativas') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('manifestacionesnegativas', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="col-6">
            <label class="form-label">Nivel*</label>
            {{ Form::select('nivel_id',$niveles, $analisis->nivel_id, ['class' => 'form-control select2' . ($errors->has('nivel_id') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('nivel_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    @endif


    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        @if ($analisisable_type == 'App\Models\Riesgo')
            <a href="{{ route('riesgos.show', $analisisable_id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @else
            <a href="{{ route('noconformidades.show', $analisisable_id) }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
        @endif
    </div>


</div>

<script type="text/javascript">
    $(function () {

        if('{{ $analisisable_type }}' == "App\Models\Riesgo"){
            select_menu('riesgos');
        }else{
            select_menu('noconformidades');
        }
      
    });
</script>