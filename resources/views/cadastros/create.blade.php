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

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('cadastros.index') }}">Cadastro de Pacientes</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('cadastros.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-5">
        <label for="nome">Nome<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') ?? '' }}">
        @if ($errors->has('nome'))
        <div class="invalid-feedback">
        {{ $errors->first('nome') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-5">
        <label for="nomeMae">Nome da Mãe<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('nomeMae') ? ' is-invalid' : '' }}" name="nomeMae" value="{{ old('nomeMae') ?? '' }}">
        @if ($errors->has('nomeMae'))
        <div class="invalid-feedback">
        {{ $errors->first('nomeMae') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="nascimento">Data Nascimento<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('nascimento') ? ' is-invalid' : '' }}" name="nascimento" id="nascimento" value="{{ old('nascimento') ?? '' }}" autocomplete="off">
        @if ($errors->has('nascimento'))
        <div class="invalid-feedback">
        {{ $errors->first('nascimento') }}
        </div>
        @endif
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="cns">CNS/CPF <strong  class="text-warning">(Opcional)</strong></label>
        <input type="text" class="form-control{{ $errors->has('cns') ? ' is-invalid' : '' }}" name="cns" value="{{ old('cns') ?? '' }}">
        @if ($errors->has('cns'))
        <div class="invalid-feedback">
        {{ $errors->first('cns') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-5">
        <label for="unidade_descricao">Unidade<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control typeahead {{ $errors->has('unidade_id') ? ' is-invalid' : '' }}" name="unidade_descricao" id="unidade_descricao" value="{{ old('unidade_descricao') ?? '' }}" autocomplete="off">       
        <input type="hidden" id="unidade_id" name="unidade_id" value="{{ old('unidade_id') ?? '' }}">
        @if ($errors->has('unidade_id'))
          <div  class="text-danger">
          {{ $errors->first('unidade_id') }}
          </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="distrito_descricao">Distrito</label>
        <input type="text" class="form-control" name="distrito_descricao" id="distrito_descricao" value="" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP<strong  class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}" name="cep" id="cep" value="{{ old('cep') ?? '' }}">
        @if ($errors->has('cep'))
        <div class="invalid-feedback">
        {{ $errors->first('cep') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-5">  
        <label for="logradouro">Logradouro <strong  class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control{{ $errors->has('logradouro') ? ' is-invalid' : '' }}" name="logradouro" id="logradouro" value="{{ old('logradouro') ?? '' }}">
        @if ($errors->has('logradouro'))
        <div class="invalid-feedback">
        {{ $errors->first('logradouro') }}
        </div>
        @endif
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº <strong  class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" name="numero" id="numero" value="{{ old('numero') ?? '' }}">
        @if ($errors->has('numero'))
        <div class="invalid-feedback">
        {{ $errors->first('numero') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento <strong  class="text-warning">(opcional)</strong></label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ old('complemento') ?? '' }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro <strong  class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control{{ $errors->has('bairro') ? ' is-invalid' : '' }}" name="bairro" id="bairro" value="{{ old('bairro') ?? '' }}">
        @if ($errors->has('bairro'))
        <div class="invalid-feedback">
        {{ $errors->first('bairro') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-6">  
        <label for="cidade">Cidade <strong  class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control{{ $errors->has('cidade') ? ' is-invalid' : '' }}" name="cidade" id="cidade" value="{{ old('cidade') ?? '' }}">
        @if ($errors->has('cidade'))
        <div class="invalid-feedback">
        {{ $errors->first('cidade') }}
        </div>
        @endif
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF <strong  class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control{{ $errors->has('uf') ? ' is-invalid' : '' }}" name="uf" id="uf" value="{{ old('uf') ?? '' }}">
        @if ($errors->has('uf'))
        <div class="invalid-feedback">
        {{ $errors->first('uf') }}
        </div>
        @endif
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cel1">N° Celular<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('cel1') ? ' is-invalid' : '' }}" name="cel1" id="cel1" value="{{ old('cel1') ?? '' }}">
        @if ($errors->has('cel1'))
        <div class="invalid-feedback">
        {{ $errors->first('cel1') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="cel2">N&lowast; Celular Alternativo <strong  class="text-warning">(opcional)</strong></label>
        <input type="text" class="form-control" name="cel2" id="cel2" value="{{ old('cel2') ?? '' }}">
      </div>
      <div class="form-group col-md-4">

      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="inicioSintomas">Data Início Sintomas<strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control{{ $errors->has('inicioSintomas') ? ' is-invalid' : '' }}" name="inicioSintomas" id="inicioSintomas" value="{{ old('inicioSintomas') ?? '' }}" autocomplete="off">
        @if ($errors->has('inicioSintomas'))
        <div class="invalid-feedback">
        {{ $errors->first('inicioSintomas') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="testeRapido">Realizou Teste Rápido/Antígeno?<strong  class="text-danger">(*)</strong></label>
        <select class="form-control {{ $errors->has('testeRapido') ? ' is-invalid' : '' }}" name="testeRapido" id="testeRapido">
          <option value="">Selecione</option>
          <option value="nao" {{ old("testeRapido") == "nao" ? "selected":"" }}>Não Coletou</option>
          <option value="positivo"  {{ old("testeRapido") == "positivo" ? "selected":"" }}>Positivo</option>      
          <option value="negativo"  {{ old("testeRapido") == "negativo" ? "selected":"" }}>Negativo</option>
        </select>
        @if ($errors->has('testeRapido'))
        <div class="invalid-feedback">
        {{ $errors->first('testeRapido') }}
        </div>
        @endif  
      </div>
      <div class="form-group col-md-4">

      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="sintomasiniciais">Sintomas Iniciais <strong  class="text-danger">(*)</strong></label>
        <select id="sintomasiniciais" name="sintomasiniciais[]" multiple="multiple">
            @foreach($sintomas as $sintoma)
            <option value="{{$sintoma->id}}">{{$sintoma->descricao}}</option>
            @endforeach
        </select>
        @if ($errors->has('sintomasiniciais'))
        <div class="text-danger">
        {{ $errors->first('sintomasiniciais') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-6">
        <label for="comorbidades">Comorbidade/Condição Prévia <strong  class="text-danger">(*)</strong></label>
        <select id="comorbidades" name="comorbidades[]" multiple="multiple">
            @foreach($comorbidades as $comorbidade)
            <option value="{{$comorbidade->id}}">{{$comorbidade->descricao}}</option>
            @endforeach
        </select>
        @if ($errors->has('comorbidades'))
        <div class="text-danger">
        {{ $errors->first('comorbidades') }}
        </div>
        @endif       
      </div>  
    </div>  

    <div class="form-group">
      <label for="notas">Notas/Observações <strong  class="text-warning">(opcional)</strong></label>
      <textarea class="form-control" name="notas" id="notas" rows="3">{{ old('notas') ?? '' }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Paciente</button>
  </form>
  <div class="float-right">
    <a href="{{ route('cadastros.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
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