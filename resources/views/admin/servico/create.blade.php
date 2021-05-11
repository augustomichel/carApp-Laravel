@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 col-12 d-flex align-items-center mb-sm-0 mb-4">
                    <h2 class="card-title">Aqui você pode criar um novo serviço, definir o tipo e o tempo de execução</h2>
                </div>
                <div class="col-sm-6 col-12 d-sm-flex justify-content-end">
                    <a href="{{ route('servico.index') }}" class="btn btn-info" role="button">Relação de Serviços</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('servico.store') }}" method="POST">

                @include('admin.layout.success')

                <div class="row">
                    <div class="col-12">
                        @csrf
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Descrição do Serviço</label>
                            <input type="text" class="form-control {{ ($errors->has('ser_descricao') ? 'is-invalid': '') }}" name="ser_descricao" placeholder="Informe a Descrição do Serviço" value="{{ old('ser_descricao') }}">

                            @if ($errors->has('ser_descricao'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ser_descricao') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Tipo de Serviço</label>

                            <select class="form-control {{ ($errors->has('ser_tipo_servico') ? 'is-invalid': '') }}" name="ser_tipo_servico">
                                <option value="">Escolha</option>
                                <option value="1">Revisão</option>
                                <option value="2">Mecânica</option>
                                <option value="3">Funilária</option>
                                <option value="4">Borracharia</option>
                            </select>

                            @if ($errors->has('ser_tipo_servico'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ser_tipo_servico') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Tempo de Execução (em minutos)</label>
                            <input type="number" class="form-control {{ ($errors->has('ser_time_execucao') ? 'is-invalid': '') }}" name="ser_time_execucao" placeholder="Exemplo: 60" value="{{ old('ser_time_execucao') }}">

                            @if ($errors->has('ser_time_execucao'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ser_time_execucao') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
        </div>
    </div>
</div>

@endsection
