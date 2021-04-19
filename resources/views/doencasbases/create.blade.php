@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('doencasbases.index') }}">Lista de Doenças Base (Monitoramento)</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('doencasbases.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" name="descricao" value="{{ old('descricao') ?? '' }}">
        @if ($errors->has('descricao'))
        <div class="invalid-feedback">
        {{ $errors->first('descricao') }}
        </div>
        @endif
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Doença Base</button>
  </form>
  <div class="float-right">
    <a href="{{ route('doencasbases.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection