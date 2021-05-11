@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('pacientes.index') }}">Lista de Pacientes</a></li>
    </ol>
  </nav>
  @if(Session::has('deleted_paciente'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <h2><span><i class="fas fa-exclamation-circle"></i></span> {{ session('deleted_paciente') }}</h2>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('restore_paciente'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <h2><span><i class="fas fa-exclamation-circle"></i></span> {{ session('restore_paciente') }}</h2>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="btn-group py-1" role="group" aria-label="Opções">
    <a href="{{ route('pacientes.create') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-plus-square"></i> Novo Registro</a>
    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-filter"></i> Filtrar</button>
    <div class="btn-group" role="group">
      <button id="btnGroupDropOptions" type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-print"></i> Relatórios
      </button>
      <div class="dropdown-menu" aria-labelledby="btnGroupDropOptions">
        <a class="dropdown-item" href="#" id="btnExportarCSV"><i class="fas fa-file-download"></i> Exportar Planilha</a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Nome da Mãe</th>
                <th scope="col">Nascimento</th>
                <th scope="col">Idade</th>
                <th scope="col">Unidade</th>
                <th scope="col">Distrito</th>
                <th scope="col">Situação</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $paciente)
            <tr>
                <td>{{$paciente->nome}}</td>
                <td>{{$paciente->nomeMae}}</td>
                <td>{{$paciente->nascimento->format('d/m/Y')}}</td>
                <td>{{$paciente->idade}}</td>
                <td>{{$paciente->unidade->descricao}}</td>
                <td>{{$paciente->unidade->distrito->nome}}</td>
                @php
                  if ($paciente->monitorando == 'n') {
                    $situacao = 'Não Monitorado';
                  }

                  if ($paciente->monitorando == 's') {
                    $situacao = 'Monitorado ' . $paciente->ultimoMonitoramento->diffForHumans();
                  }

                  if ($paciente->monitorando == 'f') {
                    $situacao = 'Alta em ' . $paciente->ultimoMonitoramento->format('d/m/Y');
                  }
                @endphp
                <td><strong>{{ $situacao }}</strong></td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('pacientes.edit', $paciente->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-edit"></i></a>
                    <a href="{{route('pacientes.show', $paciente->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-print"></i></a>
                  </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $pacientes->currentPage() }} de {{ $pacientes->lastPage() }}. Total de registros: {{ $pacientes->total() }}.</p>
  <div class="container-fluid">
      {{ $pacientes->links() }}
  </div>
  <!-- Janela de filtragem da consulta -->
  <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-filter"></i> Filtro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Filtragem dos dados -->

          <form method="GET" action="{{ route('pacientes.index') }}">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="nome">Nome do Paciente</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{request()->input('nome')}}">
              </div>
              <div class="form-group col-md-6">
                <label for="nomeMae">Nome da Mãe</label>
                <input type="text" class="form-control" id="nomeMae" name="nomeMae" value="{{request()->input('nomeMae')}}">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="unidade">Unidade</label>
                <input type="text" class="form-control" id="unidade" name="unidade" value="{{request()->input('unidade')}}">
              </div>
              <div class="form-group col-md-6">
                <label for="distrito_id">Distritos</label>
                <select class="form-control" name="distrito_id" id="distrito_id">
                  <option value="">Mostrar todos</option>
                  @foreach($distritos as $distrito)
                  <option value="{{$distrito->id}}" {{ ($distrito->id == request()->input('distrito_id')) ? ' selected' : '' }} >{{$distrito->nome}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="idadeMin">Idade (Mínima)</label>
                <input type="number" class="form-control" id="idadeMin" name="idadeMin" value="{{request()->input('idadeMin')}}">
              </div>
              <div class="form-group col-md-3">
                <label for="idadeMax">Idade (Máxima)</label>
                <input type="number" class="form-control" id="idadeMax" name="idadeMax" value="{{request()->input('idadeMax')}}">
              </div>
              <div class="form-group col-md-6">
                <label for="situacao">Situação do Paciente</label>
                <select class="form-control" name="situacao" id="situacao">
                  <option value="" selected>Mostrar Todos</option>
                  <option value="n">Mostrar Somente Pacientes Não Monitorados</option>
                  <option value="s">Mostrar Somente Pacientes Monitorados</option>
                  <option value="f">Mostrar Somente Pacientes com Alta</option>
                </select>
              </div>
            </div>
              
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Pesquisar</button>
              <a href="{{ route('pacientes.index') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
          </form>
          <br>    
          <!-- Seleção de número de resultados por página -->
          <div class="form-group">
            <select class="form-control" name="perpage" id="perpage">
              @foreach($perpages as $perpage)
              <option value="{{$perpage->valor}}"  {{($perpage->valor == session('perPage')) ? 'selected' : ''}}>{{$perpage->nome}}</option>
              @endforeach
            </select>
          </div>
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Fechar</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script-footer')
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val(); 
        
        window.open("{{ route('pacientes.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
        window.open("{{ route('pacientes.export.csv') }}","_self");
    });

}); 
</script>
@endsection