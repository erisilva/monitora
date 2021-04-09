@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Lista de Unidades</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('unidades.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" name="descricao" value="{{ old('descricao') ?? '' }}">
        @if ($errors->has('descricao'))
        <div class="invalid-feedback">
        {{ $errors->first('descricao') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="distrito_id">Distrito</label>
        <select class="form-control {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" name="distrito_id" id="distrito_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($distritos as $distrito)
          <option value="{{$distrito->id}}">{{$distrito->nome}}</option>
          @endforeach
        </select>
        @if ($errors->has('distrito_id'))
        <div class="invalid-feedback">
        {{ $errors->first('distrito_id') }}
        </div>
        @endif
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Unidade</button>
  </form>
  <div class="float-right">
    <a href="{{ route('unidades.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>

@endsection
