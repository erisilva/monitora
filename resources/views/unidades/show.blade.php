@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Lista de Unidades</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form>
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" name="descricao" value="{{ $unidade->descricao }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="distrito">Distrito</label>  
        <input type="text" class="form-control" name="distrito" id="distrito" value="{{ $unidade->distrito->nome }}" readonly>
      </div>
    </div>
        
  </form>
  
  <br>
  <div class="container">
    <form method="post" action="{{route('unidades.destroy', $unidade->id)}}"  onsubmit="return confirm('Você tem certeza que quer excluir?');">
      @csrf
      @method('DELETE')
      <a href="{{ route('unidades.index') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
      <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Excluir</button>
    </form>
  </div>
</div>

@endsection
