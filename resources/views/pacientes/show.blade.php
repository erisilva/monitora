@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('pacientes.index') }}">Lista de Pacientes</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form>
    

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $paciente->nome }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="nomeMae">Nome da Mãe</label>
        <input type="text" class="form-control" name="nomeMae" value="{{ $paciente->nomeMae }}" readonly>      
      </div>
      <div class="form-group col-md-2">
        <label for="nascimento">Nascimento</label>
        <input type="text" class="form-control" name="nascimento" value="{{ $paciente->nascimento->format('d/m/Y') }}" readonly> 
      </div>
      <div class="form-group col-md-2">
        <label for="idade">Idade</label>
        <input type="text" class="form-control" name="idade" value="{{ $paciente->idade }}" readonly> 
      </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="nome">CNS</label>
        <input type="text" class="form-control" name="nome" value="{{ $paciente->cns }}" readonly>
      </div> 
      <div class="form-group col-md-5">
        <label for="nome">Unidade</label>
        <input type="text" class="form-control" name="nome" value="{{ $paciente->unidade->descricao }}" readonly>
      </div> 
      <div class="form-group col-md-4">
        <label for="nome">Distrito</label>
        <input type="text" class="form-control" name="nome" value="{{ $paciente->unidade->distrito->nome }}" readonly>
      </div> 
    </div>



    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" name="cep" value="{{ $paciente->cep }}" readonly>
      </div> 
      <div class="form-group col-md-5">
        <label for="logradouronumero">Logradouro</label>
        <input type="text" class="form-control" name="logradouronumero" value="{{ $paciente->logradouronumero }}" readonly>
      </div> 
      <div class="form-group col-md-2">
        <label for="numero">Nº</label>
        <input type="text" class="form-control" name="numero" value="{{ $paciente->numero }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" name="complemento" value="{{ $paciente->complemento }}" readonly>
      </div> 
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" name="bairro" value="{{ $paciente->bairro }}" readonly>
      </div> 
      <div class="form-group col-md-6">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" name="cidade" value="{{ $paciente->cidade }}" readonly>
      </div> 
      <div class="form-group col-md-2">
        <label for="uf">UF</label>
        <input type="text" class="form-control" name="uf" value="{{ $paciente->uf }}" readonly>
      </div> 
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cel1">N° Celular</label>
        <input type="text" class="form-control" name="cel1" value="{{ $paciente->cel1 }}" readonly>
      </div> 
      <div class="form-group col-md-4">
        <label for="cel2">Celular Alternativo</label>
        <input type="text" class="form-control" name="cel2" value="{{ $paciente->cel2 }}" readonly>
      </div> 
      <div class="form-group col-md-4">
        <label for="email">E-mail</label>
        <input type="text" class="form-control" name="email" value="{{ $paciente->email }}" readonly>
      </div> 
    </div>

    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="inicioSintomas">Data Início Sintomas</label>
        <input type="text" class="form-control" name="inicioSintomas" value="{{ $paciente->inicioSintomas->format('d/m/Y') }}" readonly>          
      </div> 
      <div class="form-group col-md-4">
        <label for="tomouVacina">Tomou Vacina?</label>
        <input type="text" class="form-control" name="tomouVacina" value="{{ $paciente->tomouVacina }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="situacao">Situação</label>
        <p class="situacao">
          @php
          if ($paciente->monitorando == 'nao') {
            $situacao = 'Não Monitorado';
          }

          if ($paciente->monitorando == 'm24') {
            $situacao = 'Monitorar em 24hs';
          }

          if ($paciente->monitorando == 'm48') {
            $situacao = 'Monitorar em 48hs';
          }

          if ($paciente->monitorando == 'enc') {
            $situacao = 'Encaminhado para Unidade';
          }

          if ($paciente->monitorando == 'alta') {
            $situacao = 'Recebeu Alta';
          }
          @endphp
          <strong>{{ $situacao }}</strong>
        </p>
      </div>
      <div class="form-group col-md-3">
        <label for="monitorado">Situação</label>
        <p class="monitorado">
          @if(empty($paciente->ultimoMonitoramento))
            <strong>Não Monitorado</strong>
          @else
            <strong>Monitorado {{ $paciente->ultimoMonitoramento->diffForHumans() }}</strong>
          @endif
        </p>     
      </div> 
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <div class="card">
          <div class="card-header">
            Sintomas Iniciais
          </div>
          <div class="card-body">
            @foreach($paciente->sintomasCadastros as $sintoma)
              <span class="lead"><span class="badge badge-light">{{ $sintoma->descricao }}</span></span>
            @endforeach
          </div>
        </div> 
      </div> 
      <div class="form-group col-md-6">
        <div class="card">
          <div class="card-header">
            Comorbidades
          </div>
          <div class="card-body">
            @foreach($paciente->comorbidades as $comorbidade)
              <span class="lead"><span class="badge badge-light">{{ $comorbidade->descricao }}</span></span>
            @endforeach
          </div>
        </div>         
      </div>
    </div>

    <div class="form-group">
        <div class="card">
          <div class="card-header">
            Doenças de Base
          </div>
          <div class="card-body">
            @foreach($paciente->doencasBases as $doencas)
              <span class="lead"><span class="badge badge-light">{{ $doencas->descricao }}</span></span>
            @endforeach
          </div>
        </div>       
    </div>

    <div class="form-group">
      <label for="notas">Notas/Observações</label>
      <textarea class="form-control" name="notas" id="notas" rows="3" readonly>{{ $paciente->notas }}</textarea>
    </div>


    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="nome">Data do cadastro</label>
        <input type="text" class="form-control" name="nome" value="{{ $paciente->created_at->format('d/m/Y') }}" readonly>
      </div> 
      <div class="form-group col-md-3">
        <label for="nome">Hora do cadastro</label>
        <input type="text" class="form-control" name="nome" value="{{ $paciente->created_at->format('H:i') }}" readonly>
      </div> 
      <div class="form-group col-md-6">
        <label for="nome">Funcionário Responsável</label>
        <input type="text" class="form-control" name="nome" value="{{ $paciente->user->name }}" readonly>
      </div> 
    </div>
  </form>

<br>
<div class="container bg-warning text-dark">
  <p class="text-center"><strong>Monitoramentos Realizados</strong></p>
</div>

@foreach($monitoramentos as $monitoramento)

<div class="container">
  <div class="row py-2">
    <div class="col-sm-3">
      Data: {{ $monitoramento->created_at->format('d/m/Y') }}
    </div>
    <div class="col-sm-3">
      Hora: {{ $monitoramento->created_at->format('H:i') }}
    </div>
    <div class="col-sm-6">
      Responsável: {{ $monitoramento->user->name }}
    </div>
  </div>
</div>

<div class="container">
  <div class="card">
    <div class="card-header">
      Sintomas
    </div>
    <div class="card-body">
      @foreach($monitoramento->sintomas as $sintoma)
        <span class="lead"><span class="badge badge-light">{{ $sintoma->descricao }}</span></span>
      @endforeach
    </div> 
  </div>
</div>

<div class="container">
  <div class="row py-2">
    <div class="col-sm-4">
      Apresentando febre? {{ $monitoramento->febre }}  
    </div>
    <div class="col-sm-4">
      É diabético?  {{ $monitoramento->diabetico }}
    </div>
    <div class="col-sm-4">
      Mediu sua glicemia hoje?  {{ $monitoramento->glicemia }} 
    </div>
  </div>
  <div class="row py-2">
    <div class="col-sm-4">
      Realizou RT-PCR?  {{ $monitoramento->teste }} 
    </div>
    <div class="col-sm-4">
      O resultado foi?  {{ $monitoramento->resultado }}
    </div>
    <div class="col-sm-4">
      Como está a sua saúde em relação a ontem?  {{ $monitoramento->saude }}
    </div>    
  </div>
  <div class="row py-2">
    <div class="col-sm-12">
      <strong>História Clinica:</strong>  {{ $monitoramento->historico }} 
    </div>
  </div>  
  <div class="row py-2">
    <div class="col-sm-6">
      Existem pessoas vacinadas em sua casa?  {{ $monitoramento->familia }} 
    </div>
    <div class="col-sm-6">
      Quantas? {{ $monitoramento->quantas }} 
    </div>
  </div> 
  <hr class="my-4">
</div>

@endforeach
<br>
  <div class="container">
    <a href="{{ route('pacientes.index') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalLixeira"><i class="fas fa-trash-alt"></i> Enviar para Lixeira</button>
  </div>
  <div class="modal fade" id="modalLixeira" tabindex="-1" role="dialog" aria-labelledby="JanelaProfissional" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-question-circle"></i> Enviar esse registro para a lixeira?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" role="alert">
            <h2>Confirma?</h2>
          </div>
          <form method="post" action="{{route('pacientes.destroy', $paciente->id)}}">
            @csrf
            @method('DELETE')
            <div class="form-group">
              <label for="motivo">Motivo</label>  
              <input type="text" class="form-control" name="motivo" id="motivo" value="">
            </div>
            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Enviar para Lixeira</button>
          </form>
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cancelar</button>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
