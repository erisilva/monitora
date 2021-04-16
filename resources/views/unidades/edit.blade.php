@extends('layouts.app')

@section('css-header')
<style>
  .twitter-typeahead, .tt-hint, .tt-input, .tt-menu { width: 100%; }
  .tt-query, .tt-hint { outline: none;}
  .tt-query { box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);}
  .tt-hint {color: #999;}
  .tt-menu { 
      width: 100%;
      margin-top: 12px;
      padding: 8px 0;
      background-color: #fff;
      border: 1px solid #ccc;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      box-shadow: 0 5px 10px rgba(0,0,0,.2);
  }
  .tt-suggestion { padding: 3px 20px; }
  .tt-suggestion.tt-is-under-cursor { color: #fff; }
  .tt-suggestion p { margin: 0;}
</style>
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Lista de Unidades</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  @if(Session::has('edited_unidade'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('edited_unidade') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <form method="POST" action="{{ route('unidades.update', $unidade->id) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" name="descricao" value="{{ $unidade->descricao }}">
      </div>
      <div class="form-group col-md-4">
        <label for="distrito_id">Distrito</label>
        <select class="form-control" name="distrito_id" id="distrito_id">
          <option value="{{ $unidade->distrito->id }}" selected="true"> &rarr; {{ $unidade->distrito->nome }}</option>  
          @foreach($distritos as $distrito)
          <option value="{{$distrito->id}}">{{$distrito->nome}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Alterar Dados da Unidade</button>
  </form>
</div>
<br>

<div class="container">
  <div class="float-right">
    <a href="{{ route('unidades.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection
