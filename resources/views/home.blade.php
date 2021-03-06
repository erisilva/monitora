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
<div class="container py-3 text-center">
    <h1>Sistema de Monitoramento da COVID</span></h1>   
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
            '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhuma unidade com o texto digitado.</p>',
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