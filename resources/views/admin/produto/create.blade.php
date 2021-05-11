@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 col-12 d-flex align-items-center mb-sm-0 mb-4">
                    <h2 class="card-title">Aqui você pode criar um novo produto</h2>
                </div>
                <div class="col-sm-6 col-12 d-sm-flex justify-content-end">
                    <a href="{{ route('produto.index') }}" class="btn btn-info" role="button">Relação de Produtos</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('produto.store') }}" method="POST">

                @include('admin.layout.success')

                <div class="row">
                    <div class="col-12">
                        @csrf
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Nome do Produto</label>
                            <input type="text" class="form-control {{ ($errors->has('pro_nome') ? 'is-invalid': '') }}" name="pro_nome" placeholder="Informe o Nome do Produto" value="{{ old('pro_nome') }}">

                            @if ($errors->has('pro_nome'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('pro_nome') }}
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
