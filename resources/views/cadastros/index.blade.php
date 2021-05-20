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


@if(Session::has('create_paciente'))
<div class="container py-3 text-center">
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <h2><span><i class="fas fa-exclamation-circle"></i></span> {{ session('create_paciente') }}</h2>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
@endif


<div class="container py-3 text-center">
    <h1><span><i class="fas fa-search"></i> Consulta de Pacientes</span></h1>   
</div>

<div class="container py-3">

    <form>
        <div class="form-group">
            <input type="text" class="form-control form-control-lg typeahead" name="pesquisa" id="pesquisa" value="" autocomplete="off">
        </div>
    </form>
</div>

<div class="container py-3 text-right">
    <a href="{{ route('cadastros.create') }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"><i class="fas fa-user-plus"></i> Cadastrar Paciente</a>  
</div>

@endsection

@section('script-footer')
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script>
$(document).ready(function(){

  var pacientes = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
          url: "{{route('pacientes.autocomplete')}}?query=%QUERY",
          wildcard: '%QUERY'
      }
  });
  pacientes.initialize();

  $("#pesquisa").typeahead({
      hint: true,
      highlight: true,
      minLength: 3,
  },
  {
      name: "pacientes",
      displayKey: "text",
      source: pacientes.ttAdapter(),
      limit: 7,
      templates: {
        empty: [
          '<div class="empty-message">',
            '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhuma registro com o texto digitado.</p>',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return '<div class="container py-2">' + 
                     '<div class="row">' +
                       '<div class="col-6">' +
                            '<h3>' + data.text + '</h3>' +
                       '</div>' +
                       '<div class="col-4">' +
                            'Mãe: ' + data.mae +
                       '</div>' +
                       '<div class="col-2">' +
                            'Nasc.: ' + data.nascimento +
                       '</div>' +
                     '</div>' + 
                   '</div>';
          }
      }    
      }).on("typeahead:selected", function(obj, datum, name) {
          $(this).data("seletectedId", datum.value);
      }).on('typeahead:autocompleted', function (e, datum) {
          $(this).data("seletectedId", datum.value);
  });

});
</script>
@endsection 