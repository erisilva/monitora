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
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.min.css') }}">
@endsection

<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('pacientes.index') }}">Lista de Pacientes</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  @if(Session::has('edited_paciente'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <h2><span><i class="fas fa-exclamation-circle"></i></span> {{ session('edited_paciente') }}</h2>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_paciente'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <h2><span><i class="fas fa-exclamation-circle"></i></span> {{ session('create_paciente') }}</h2>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_monitoramento'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <h2><span><i class="fas fa-exclamation-circle"></i></span> {{ session('create_monitoramento') }}</h2>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nome">Nome<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') ?? $paciente->nome }}">
        @if ($errors->has('nome'))
        <div class="invalid-feedback">
        {{ $errors->first('nome') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="nomeMae">Nome da Mãe<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('nomeMae') ? ' is-invalid' : '' }}" name="nomeMae" value="{{ old('nomeMae') ?? $paciente->nomeMae }}">
        @if ($errors->has('nomeMae'))
        <div class="invalid-feedback">
        {{ $errors->first('nomeMae') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="nascimento">Nascimento<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('nascimento') ? ' is-invalid' : '' }}" name="nascimento" id="nascimento" value="{{ old('nascimento') ?? $paciente->nascimento->format('d/m/Y') }}">
        @if ($errors->has('nascimento'))
        <div class="invalid-feedback">
        {{ $errors->first('nascimento') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="idade">Idade</label>
        <input type="text" class="form-control" name="idade" value="{{ $paciente->idade }}" readonly> 
      </div>
    </div>



    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="cns">CNS <strong  class="text-warning">(Opcional)</strong></label>
        <input type="text" class="form-control" name="cns" value="{{ old('cns') ?? $paciente->cns }}">
      </div>

      <div class="form-group col-md-5">
        <label for="unidade_descricao">Unidade<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control typeahead {{ $errors->has('unidade_id') ? ' is-invalid' : '' }}" name="unidade_descricao" id="unidade_descricao" value="{{ old('unidade_descricao') ?? $paciente->unidade->descricao }}" autocomplete="off">       
        <input type="hidden" id="unidade_id" name="unidade_id" value="{{ old('unidade_id') ?? $paciente->unidade_id }}">
        @if ($errors->has('unidade_id'))
          <div class="invalid-feedback">
          {{ $errors->first('unidade_id') }}
          </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="distrito_descricao">Distrito</label>
        <input type="text" class="form-control" name="distrito_descricao" id="distrito_descricao" value="{{ old('distrito_descricao') ?? $paciente->unidade->distrito->nome }}" readonly>
      </div>
    </div>





    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}" name="cep" value="{{ old('cep') ?? $paciente->cep }}" id="cep">
        @if ($errors->has('cep'))
        <div class="invalid-feedback">
        {{ $errors->first('cep') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-5">
        <label for="logradouro">Logradouro<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('logradouro') ? ' is-invalid' : '' }}" name="logradouro" value="{{ old('logradouro') ?? $paciente->logradouro }}" id="logradouro">
        @if ($errors->has('logradouro'))
        <div class="invalid-feedback">
        {{ $errors->first('logradouro') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="numero">Nº <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" name="numero" value="{{ old('numero') ?? $paciente->numero }}" id="numero">
        @if ($errors->has('numero'))
        <div class="invalid-feedback">
        {{ $errors->first('numero') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-3">
        <label for="complemento">Complemento <strong  class="text-warning">(opcional)</strong></label>
        <input type="text" class="form-control" name="complemento" value="{{ old('complemento') ?? $paciente->complemento }}" id="complemento">
      </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('bairro') ? ' is-invalid' : '' }}" name="bairro" value="{{ old('bairro') ?? $paciente->bairro }}" id="bairro">
        @if ($errors->has('bairro'))
        <div class="invalid-feedback">
        {{ $errors->first('bairro') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-6">
        <label for="cidade">Cidade <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('cidade') ? ' is-invalid' : '' }}" name="cidade" value="{{ old('cidade') ?? $paciente->cidade }}" id="cidade">
        @if ($errors->has('cidade'))
        <div class="invalid-feedback">
        {{ $errors->first('cidade') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="uf">UF <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('uf') ? ' is-invalid' : '' }}" name="uf" value="{{ old('uf') ?? $paciente->uf }}" id="uf">
        @if ($errors->has('uf'))
        <div class="invalid-feedback">
        {{ $errors->first('uf') }}
        </div>
        @endif
      </div>
    </div>



    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cel1">N°&lowast; Celular<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('cel1') ? ' is-invalid' : '' }}" name="cel1" value="{{ old('cel1') ?? $paciente->cel1 }}" id="cel1">
        @if ($errors->has('cel1'))
        <div class="invalid-feedback">
        {{ $errors->first('cel1') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="cel1">N&lowast; Celular Alternativo <strong  class="text-warning">(opcional)</strong></label>
        <input type="text" class="form-control" name="cel1" value="{{ old('cel1') ?? $paciente->cel1 }}" id="cel1">
      </div>
      <div class="form-group col-md-4">
        <label for="email">E-mail <strong  class="text-warning">(opcional)</strong></label>
        <input type="text" class="form-control" name="email" value="{{ old('email') ?? $paciente->email }}" id="cel1">
      </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="inicioSintomas">Data Início Sintomas<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('inicioSintomas') ? ' is-invalid' : '' }}" name="inicioSintomas" id="inicioSintomas" value="{{ old('inicioSintomas') ?? $paciente->inicioSintomas->format('d/m/Y') }}">
        @if ($errors->has('inicioSintomas'))
        <div class="invalid-feedback">
        {{ $errors->first('inicioSintomas') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="tomouVacina">Tomou Vacina?<strong  class="text-danger">(*)</strong></label>
        <select class="form-control {{ $errors->has('tomouVacina') ? ' is-invalid' : '' }}" name="tomouVacina" id="tomouVacina">
          <option value="nao" {{ $paciente->tomouVacina == "nao" ? "selected":"" }}>Não</option>
          <option value="sim, 1 dose"  {{ $paciente->tomouVacina == "sim, 1 dose" ? "selected":"" }}>Sim, 1 dose</option>      
          <option value="sim, 2 doses"  {{ $paciente->tomouVacina == "sim, 2 doses" ? "selected":"" }}>Sim, 2 doses</option>
        </select>
        @if ($errors->has('tomouVacina'))
        <div class="invalid-feedback">
        {{ $errors->first('tomouVacina') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="sintomasiniciais">Sintomas iniciais <strong  class="text-warning">(opcional)</strong></label>
        <select id="sintomasiniciais" name="sintomasiniciais[]" multiple="multiple">
            @foreach($sintomas as $sintoma)
            @php
            $selected = '';
            if(old('sintomasiniciais') ?? false){
              foreach (old('sintomasiniciais') as $key => $id) {
                if($id == $sintoma->id){
                  $selected = "selected";
                }
              }  
            } else {
              foreach ($paciente->sintomasCadastros as $key => $sintomasList) {
                if($sintomasList->id == $sintoma->id){
                  $selected = "selected";
                }
              }
            }
            @endphp
            <option value="{{$sintoma->id}}" {{ $selected }}>{{$sintoma->descricao}}</option>
            @endforeach
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="comorbidades">Comorbidades <strong  class="text-warning">(opcional)</strong></label>
        <select id="comorbidades" name="comorbidades[]" multiple="multiple">
            @foreach($comorbidades as $comorbidade)
            @php
            $selected = '';
            if(old('comorbidades') ?? false){
              foreach (old('comorbidades') as $key => $id) {
                if($id == $comorbidade->id){
                  $selected = "selected";
                }
              }  
            } else {
              foreach ($paciente->comorbidades as $key => $comorbidadesList) {
                if($comorbidadesList->id == $comorbidade->id){
                  $selected = "selected";
                }
              }
            }
            @endphp
            <option value="{{$comorbidade->id}}"  {{ $selected }}>{{$comorbidade->descricao}}</option>
            @endforeach
        </select>
      </div>
    </div>


    <div class="form-row">
      <div class="form-group col-md-6">
      <label for="doencas">Doenças de Base <strong  class="text-warning">(opcional)</strong></label>
      <select id="doencas" name="doencas[]" multiple="multiple">
          @foreach($doencas as $doenca)
          @php
            $selected = '';
            if(old('doencas') ?? false){
              foreach (old('doencas') as $key => $id) {
                if($id == $doenca->id){
                  $selected = "selected";
                }
              }  
            } else {
              foreach ($paciente->doencasBases as $key => $doencasbaseList) {
                if($doencasbaseList->id == $doenca->id){
                  $selected = "selected";
                }
              }
            }
            @endphp
          <option value="{{$doenca->id}}"  {{ $selected }}>{{$doenca->descricao}}</option>
          @endforeach
      </select> 
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
        <label for="monitorado">Monitorado?</label>
        <p class="monitorado">
          @if(empty($paciente->ultimoMonitoramento))
            <strong>Não Monitorado</strong>
          @else
            <strong>Monitorado {{ $paciente->ultimoMonitoramento->diffForHumans() }}</strong>
          @endif
        </p>
      </div>
    </div>  


    <div class="form-group">
      <label for="notas">Notas/Observações <strong  class="text-warning">(opcional)</strong></label>
      <textarea class="form-control" name="notas" id="notas" rows="3">{{ old('notas') ?? $paciente->notas }}</textarea>
    </div>


    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="data_do_cadastro">Data do cadastro</label>
        <input type="text" class="form-control" name="data_do_cadastro" value="{{ $paciente->created_at->format('d/m/Y') }}" readonly>
      </div> 
      <div class="form-group col-md-3">
        <label for="hora_do_cadastro">Hora do cadastro</label>
        <input type="text" class="form-control" name="hora_do_cadastro" value="{{ $paciente->created_at->format('H:i') }}" readonly>
      </div> 
      <div class="form-group col-md-6">
        <label for="funcionario_responsavel">Funcionário Responsável</label>
        <input type="text" class="form-control" name="funcionario_responsavel" value="{{ $paciente->user->name }}" readonly>
      </div> 
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Alterar Dados do Paciente</button>
  </form>
</div>

<br>
<div class="container bg-warning text-dark">
  <p class="text-center"><strong>Monitorar Paciente</strong></p>
</div>
<div class="container">

  <form method="POST" action="{{ route('monitoramentos.store') }}">
      @csrf
      <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $paciente->id }}">
      <div class="form-row">
        <div class="form-group col-md-8">
          <label for="sintomasmonitoramento">Sintomas <strong  class="text-warning">(opcional)</strong></label>
          <select id="sintomasmonitoramento" name="sintomasmonitoramento[]" multiple="multiple">
              @foreach($sintomas_monitoramento as $sintoma)
              <option value="{{$sintoma->id}}">{{$sintoma->descricao}}</option>
              @endforeach
          </select>
        </div>  
        <div class="form-group col-md-4">
          <label for="febre">Apresentando febre?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('febre') ? ' is-invalid' : '' }}" name="febre" id="febre">
            <option value="">Selecione</option>
            <option value="nao" {{ old('febre') == 'nao' ? 'selected':'' }}>Não</option>
            <option value="sim"  {{ old('febre') == 'sim' ? 'selected':'' }}>Sim</option>
            <option value="nao atendeu"  {{ old('febre') == 'nao atendeu' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('febre'))
          <div class="invalid-feedback">
          {{ $errors->first('febre') }}
          </div>
          @endif           
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="diabetico">É diabético?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('diabetico') ? ' is-invalid' : '' }}" name="diabetico" id="diabetico">
            <option value="">Selecione</option>
            <option value="nao" {{ old('diabetico') == 'nao' ? 'selected':'' }}>Não</option>
            <option value="sim"  {{ old('diabetico') == 'sim' ? 'selected':'' }}>Sim</option>
            <option value="nao informado"  {{ old('diabetico') == 'nao informado' ? 'selected':'' }}>Não Informado</option>
            <option value="nao atendeu"  {{ old('diabetico') == 'nao atendeu' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('diabetico'))
          <div class="invalid-feedback">
          {{ $errors->first('diabetico') }}
          </div>
          @endif           
        </div>  
        <div class="form-group col-md-3">
          <label for="glicemia">Mediu sua glicemia hoje?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('glicemia') ? ' is-invalid' : '' }}" name="glicemia" id="glicemia">
            <option value="">Selecione</option>
            <option value="nao" {{ old('glicemia') == 'nao' ? 'selected':'' }}>Não</option>
            <option value="menos de 200"  {{ old('glicemia') == 'menos de 200' ? 'selected':'' }}>Menos de 200</option>
            <option value="200 a 300"  {{ old('glicemia') == '200 a 300' ? 'selected':'' }}>200 a 300</option>
            <option value="mais de 350"  {{ old('glicemia') == 'mais de 350' ? 'selected':'' }}>Mais de 350</option>
            <option value="nao informado"  {{ old('glicemia') == 'nao informado' ? 'selected':'' }}>Não Informado</option>
            <option value="nao atendeu"  {{ old('glicemia') == 'nao atendeu' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('glicemia'))
          <div class="invalid-feedback">
          {{ $errors->first('glicemia') }}
          </div>
          @endif          
        </div>
        <div class="form-group col-md-3">
          <label for="teste">Realizou RT-PCR?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('teste') ? ' is-invalid' : '' }}" name="teste" id="teste">
            <option value="">Selecione</option>
            <option value="nao" {{ old('teste') == 'nao' ? 'selected':'' }}>Não</option>
            <option value="sim"  {{ old('teste') == 'sim' ? 'selected':'' }}>Sim</option>
            <option value="nao sabe"  {{ old('teste') == 'nao sabe' ? 'selected':'' }}>Não Sabe</option>
            <option value="nao atendeu"  {{ old('teste') == 'nao atendeu' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('teste'))
          <div class="invalid-feedback">
          {{ $errors->first('teste') }}
          </div>
          @endif 
        </div>
        <div class="form-group col-md-3">
          <label for="resultado">O resultado foi?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('resultado') ? ' is-invalid' : '' }}" name="resultado" id="resultado">
            <option value="">Selecione</option>
            <option value="nao" {{ old('resultado') == 'nao' ? 'selected':'' }}>Não Fez o Teste</option>
            <option value="positivo" {{ old('resultado') == 'positivo' ? 'selected':'' }}>Positivo</option>
            <option value="negativo"  {{ old('resultado') == 'negativo' ? 'selected':'' }}>Negativo</option>
            <option value="indeterminado"  {{ old('resultado') == 'indeterminado' ? 'selected':'' }}>Indeterminado</option>
            <option value="nao sabe"  {{ old('resultado') == 'nao sabe' ? 'selected':'' }}>Não sabe</option>
            <option value="nao atendeu"  {{ old('resultado') == 'nao atendeu' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('resultado'))
          <div class="invalid-feedback">
          {{ $errors->first('resultado') }}
          </div>
          @endif            
        </div>
      </div>

      <div class="form-group">
        <label for="historico">História Clinica <strong  class="text-warning">(opcional)</strong></label>
        <textarea class="form-control" name="historico" id="historico" rows="5">{{ old('historico') ?? '' }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="saude">Como está a sua saúde em relação a ontem?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('saude') ? ' is-invalid' : '' }}" name="saude" id="saude">
            <option value="">Selecione</option>
            <option value="pior" {{ old('saude') == 'pior' ? 'selected':'' }}>Pior</option>
            <option value="igual"  {{ old('saude') == 'igual' ? 'selected':'' }}>Igual</option>
            <option value="melhor"  {{ old('saude') == 'melhor' ? 'selected':'' }}>Melhor</option>
            <option value="nao atendeu"  {{ old('saude') == 'nao atendeu' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('saude'))
          <div class="invalid-feedback">
          {{ $errors->first('saude') }}
          </div>
          @endif 
        </div>  
        <div class="form-group col-md-4">
          <label for="familia">Existem pessoas vacinadas em sua casa?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('familia') ? ' is-invalid' : '' }}" name="familia" id="familia">
            <option value="">Selecione</option>
            <option value="nao" {{ old('familia') == 'nao' ? 'selected':'' }}>Não</option>
            <option value="sim"  {{ old('familia') == 'sim' ? 'selected':'' }}>Sim</option>
            <option value="nao sabe"  {{ old('familia') == 'nao sabe' ? 'selected':'' }}>Não Sabe</option>
            <option value="nao atendeu"  {{ old('familia') == 'nao atendeu' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('familia'))
          <div class="invalid-feedback">
          {{ $errors->first('familia') }}
          </div>
          @endif          
        </div>
        <div class="form-group col-md-4">
          <label for="quantas">Quantas?<strong  class="text-warning">(Opcional)</strong></label>
          <input type="number" class="form-control" name="quantas" value="{{ old('quantas') ?? '' }}"> 
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4 bg-primary text-white py-2">
          <label for="acao">Escolher uma Ação?<strong  class="text-danger">(*)</strong></label>
          <select class="form-control {{ $errors->has('acao') ? ' is-invalid' : '' }}" name="acao" id="acao">
            <option value="">Selecione</option>
            <option value="m24" {{ old('acao') == 'm24' ? 'selected':'' }}>Monitorar em 24hs</option>
            <option value="m48"  {{ old('acao') == 'm48' ? 'selected':'' }}>Monitorar em 48hs</option>
            <option value="enc"  {{ old('acao') == 'enc' ? 'selected':'' }}>Encaminhado para Unidade</option>
            <option value="alta"  {{ old('acao') == 'alta' ? 'selected':'' }}>Dar Alta</option>
            <option value="nao"  {{ old('acao') == 'nao' ? 'selected':'' }}>Não Atendeu</option>
          </select>
          @if ($errors->has('acao'))
          <div class="invalid-feedback">
          {{ $errors->first('acao') }}
          </div>
          @endif  
        </div>
        <div class="form-group col-md-8">

        </div>  
      </div>  
      <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Salvar Monitoramento</button>
  </form>

</div>

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
  <div class="float-right">
    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-multiselect.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script>
  $(document).ready(function(){

      $('#nascimento').datepicker({
          format: "dd/mm/yyyy",
          todayBtn: "linked",
          clearBtn: true,
          language: "pt-BR",
          autoclose: true,
          todayHighlight: true,
          forceParse: true
      });

      $('#inicioSintomas').datepicker({
          format: "dd/mm/yyyy",
          todayBtn: "linked",
          clearBtn: true,
          language: "pt-BR",
          autoclose: true,
          todayHighlight: true,
          forceParse: true
      });

      $.fn.multiselect.Constructor.prototype.defaults.selectAllText = " Selecionar Todos";
      $.fn.multiselect.Constructor.prototype.defaults.filterPlaceholder = "Buscar";
      $.fn.multiselect.Constructor.prototype.defaults.nonSelectedText = "Nenhum Selecionado";
      $.fn.multiselect.Constructor.prototype.defaults.nSelectedText = "selecionado(s)";
      $.fn.multiselect.Constructor.prototype.defaults.allSelectedText = "Todos selecionados";

      $('#comorbidades').multiselect({
                includeSelectAllOption: true,
                buttonWidth: '100%'
              });

      $('#sintomasiniciais').multiselect({
                includeSelectAllOption: true,
                buttonWidth: '100%'
              });

      $('#doencas').multiselect({
                includeSelectAllOption: true,
                buttonWidth: '100%'
              });

      $('#sintomasmonitoramento').multiselect({
                includeSelectAllOption: true,
                buttonWidth: '100%'
              });

      $("#cpf").inputmask({"mask": "999.999.999-99"});
      $("#cel1").inputmask({"mask": "(99) 99999-9999"});
      $("#cel2").inputmask({"mask": "(99) 99999-9999"});
      $("#cep").inputmask({"mask": "99.999-999"});

      function limpa_formulario_cep() {
          $("#logradouro").val("");
          $("#bairro").val("");
          $("#cidade").val("");
          $("#uf").val("");
      }
      
    $("#cep").blur(function () {
          var cep = $(this).val().replace(/\D/g, '');
          if (cep != "") {
              var validacep = /^[0-9]{8}$/;
              if(validacep.test(cep)) {
                  $("#logradouro").val("...");
                  $("#bairro").val("...");
                  $("#cidade").val("...");
                  $("#uf").val("...");
                  $.ajax({
                      dataType: "json",
                      url: "http://srvsmsphp01.brazilsouth.cloudapp.azure.com:9191/cep/?value=" + cep,
                      type: "GET",
                      success: function(json) {
                          if (json['erro']) {
                              limpa_formulario_cep();
                              console.log('cep inválido');
                          } else {
                              $("#bairro").val(json[0]['bairro']);
                              $("#cidade").val(json[0]['cidade']);
                              $("#uf").val(json[0]['uf'].toUpperCase());
                              $("#logradouro").val(json[0]['rua']);
                          }
                      }
                  });
              } else {
                  limpa_formulario_cep();
              }
          } else {
              limpa_formulario_cep();
          }
      });

  var unidades = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
          url: "{{route('unidades.autocomplete')}}?query=%QUERY",
          wildcard: '%QUERY'
      },
      limit: 10
  });
  unidades.initialize();

  $("#unidade_descricao").typeahead({
      hint: true,
      highlight: true,
      minLength: 1
  },
  {
      name: "unidades",
      displayKey: "text",

      source: unidades.ttAdapter(),
      templates: {
        empty: [
          '<div class="empty-message">',
            '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhuma unidade com o texto digitado.</p>',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return '<div>' + data.text + '<strong> - Distrito: ' + data.distrito + '</strong>' + '</div>';
          }
      }    
      }).on("typeahead:selected", function(obj, datum, name) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
          console.log(datum.value);
          console.log(datum.distrito);
      }).on('typeahead:autocompleted', function (e, datum) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
          console.log(datum.value);
          console.log(datum.distrito);
  });     

  });
</script>

@endsection