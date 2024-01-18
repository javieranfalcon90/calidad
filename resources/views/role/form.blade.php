<div class="row g-3">      
        
    <div class="col-12">
        <label class="form-label">Nombre*</label>
            {{ Form::text('name', $role->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => '']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="col-12">
        <label class="form-label">Permisos</label>

        <button type="button" class="btn btn-link selectall">Select All</button>
        <button type="button" class="btn btn-link deselectall">Deselect All</button>

        <div class="row">

            @foreach ($groups as $g)

                <div class="col-3">
                <div class="card">
                    <div class="card-body" style="height: 100%">
                        <h5 class="card-title">{{ $g }}</h5>

                        @foreach ($permissions as $p)
                            @if($p->group == $g)
                                <div class="form-check">
                                    <input name="permissions[]" class="form-check-input permissions" 
                                        type="checkbox" id="{{ $p->id }}" 
                                        value="{{ $p->name }}" 
                                        @foreach ($role->permissions as $pp)
                                            @if($pp->id == $p->id)
                                                checked = ""
                                            @endif
                                        @endforeach>

                                    <label class="form-check-label" for="{{ $p->id }}">
                                    {{ $p->name }}
                                    </label>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
                </div>
                
            @endforeach      

        </div>
    </div>


    <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Guardar</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Cancelar</a>
    </div>
</div>

<script type="text/javascript">
    $(function () {

        select_menu('seguridad');

        $('.selectall').click(function(){
            $(".permissions").prop('checked', 'checked');
        });

        $('.deselectall').click(function(){
            $(".permissions").prop('checked', '');
        });
      
    });
</script>