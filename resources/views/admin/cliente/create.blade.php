@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 col-12 d-flex align-items-center mb-sm-0 mb-4">
                    <h2 class="card-title">Aqui você pode criar uma nova concessionária</h2>
                </div>
                <div class="col-sm-6 col-12 d-sm-flex justify-content-end">
                    <a href="{{ route('cliente.index') }}" class="btn btn-info" role="button">Relação de Concessionárias</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('cliente.store') }}" method="POST">

                @include('admin.layout.success')

                <div class="row">
                    <div class="col-12">
                        @csrf
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Nome da Concessionária</label>
                            <input type="text" class="form-control {{ ($errors->has('cli_nome') ? 'is-invalid': '') }}" name="cli_nome" placeholder="Informe o Nome" value="{{ old('cli_nome') }}">

                            @if ($errors->has('cli_nome'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cli_nome') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">CNPJ</label>
                            <input type="text" class="form-control {{ ($errors->has('cli_cnp') ? 'is-invalid': '') }}" name="cli_cnp" placeholder="Informe o CNPJ" value="{{ old('cli_cnp') }}">

                            @if ($errors->has('cli_cnp'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cli_cnp') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Concessionária Matriz</label>

                            <select class="form-control {{ ($errors->has('cli_matriz') ? 'is-invalid': '') }}" name="cli_matriz">
                                <option value="">Escolha</option>
                                @foreach ($matrizes as $matriz)
                                <option value="{{ $matriz->cli_codigo }}">{{ $matriz->cli_nome }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('cli_matriz'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cli_matriz') }}
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
