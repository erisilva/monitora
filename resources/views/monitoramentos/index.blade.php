@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('monitoramentos.index') }}">Lista de Monitoramentos</a></li>
    </ol>
  </nav>

  <div class="btn-group py-1" role="group" aria-label="Opções">
    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-filter"></i> Filtrar</button>
    <div class="btn-group" role="group">
      <button id="btnGroupDropOptions" type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-print"></i> Relatórios
      </button>
      <div class="dropdown-menu" aria-labelledby="btnGroupDropOptions">
        <a class="dropdown-item" href="#" id="btnExportarCSV"><i class="fas fa-file-download"></i> Exportar Planilha</a>
        <a class="dropdown-item" href="#" id="btnExportarPDF"><i class="fas fa-file-download"></i> Exportar PDF</a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Hora</th>
                <th scope="col">Nome do Paciente</th>
                <th scope="col">Nome da Mãe</th>
                <th scope="col">Nascimento</th>
                <th scope="col">Unidade</th>
                <th scope="col">Distrito</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($monitoramentos as $monitoramento)
            <tr>
                <td>{{ $monitoramento->created_at->format('d/m/Y') }}</td>
                <td>{{ $monitoramento->created_at->format('H:i') }}</td>
                <td>{{ $monitoramento->paciente->nome }}</td>
                <td>{{ $monitoramento->paciente->nomeMae }}</td>
                <td>{{ $monitoramento->paciente->nascimento->format('d/m/Y') }}</td>
                <td>{{ $monitoramento->paciente->unidade->descricao }}</td>
                <td>{{ $monitoramento->paciente->unidade->distrito->nome }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('monitoramentos.edit', $monitoramento->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-edit"></i></a>
                    <a href="{{route('monitoramentos.show', $monitoramento->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-trash-alt"></i></a>
                  </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $monitoramentos->currentPage() }} de {{ $monitoramentos->lastPage() }}. Total de registros: {{ $monitoramentos->total() }}.</p>
  <div class="container-fluid">
      {{ $monitoramentos->links() }}
  </div>
  <!-- Janela de filtragem da consulta -->
  <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-filter"></i> Filtro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Filtragem dos dados -->
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
        
        window.open("{{ route('monitoramentos.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
        window.open("{{ route('monitoramentos.export.csv') }}","_self");
    });

    $('#btnExportarPDF').on('click', function(){
        window.open("{{ route('monitoramentos.export.pdf') }}","_self");
    });
}); 
</script>
@endsection