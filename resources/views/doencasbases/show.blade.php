@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('doencasbases.index') }}">Lista de Doenças Base (Monitoramento)</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <div class="card">
    <div class="card-header">
      Doença Base (Monitoramento)
    </div>
    <div class="card-body">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Nome: {{$doencasbase->descricao}}</li>
      </ul>
    </div>
    <div class="card-footer text-muted">
      <form method="post" action="{{route('doencasbases.destroy', $doencasbase->id)}}"  onsubmit="return confirm('Você tem certeza que quer excluir?');">
        @csrf
        @method('DELETE')
        <a href="{{ route('doencasbases.index') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>  
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Excluir</button>
      </form>
    </div>
  </div>  
  <br>
</div>

@endsection
