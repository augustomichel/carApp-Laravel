@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 col-12 d-flex align-items-center mb-sm-0 mb-4">
                    <h2 class="card-title">Aqui você pode criar um novo usuário e definir os níveis de acesso</h2>
                </div>
                <div class="col-sm-6 col-12 d-sm-flex justify-content-end">
                    <a href="{{ route('usuario.index') }}" class="btn btn-info" role="button">Relação de Usuários</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('usuario.store') }}" method="POST">

                @include('admin.layout.success')

                <div class="row">
                    <div class="col-12">
                        @csrf
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Nome do Usuário</label>
                            <input type="text" class="form-control {{ ($errors->has('usu_nome') ? 'is-invalid': '') }}" name="usu_nome" placeholder="Informe o Nome Completo" value="{{ old('usu_nome') }}">

                            @if ($errors->has('usu_nome'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('usu_nome') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">E-mail</label>
                            <input type="text" class="form-control {{ ($errors->has('usu_email') ? 'is-invalid': '') }}" name="usu_email" placeholder="Informe o E-mail para Login" value="{{ old('usu_email') }}">

                            @if ($errors->has('usu_email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('usu_email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Senha</label>
                            <input type="password" class="form-control {{ ($errors->has('usu_senha') ? 'is-invalid': '') }}" name="usu_senha" placeholder="Informe a Senha" value="{{ old('usu_senha') }}">

                            @if ($errors->has('usu_senha'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('usu_senha') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Nível de Acesso</label>

                            <select class="form-control {{ ($errors->has('usu_nivel') ? 'is-invalid': '') }}" name="usu_nivel">
                                <option value="">Escolha</option>
                                @foreach ($niveis as $nivel)
                                <option value="{{ $nivel->usn_codigo }}">{{ $nivel->usn_descricao }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('usu_nivel'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('usu_nivel') }}
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
