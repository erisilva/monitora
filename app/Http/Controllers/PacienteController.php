<?php

namespace App\Http\Controllers;

use App\Paciente;
use App\Distrito;
use App\DoencasBase;
use App\SintomasCadastro;
use App\Sintoma;
use App\Comorbidade;
use App\Monitoramento;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon; // tratamento de datas

use Auth;

use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

use Illuminate\Database\Eloquent\Builder; // para poder usar o whereHas nos filtros

class PacienteController extends Controller
{
    protected $pdf;

    /**
     * Construtor.
     *
     * precisa estar logado ao sistema
     * precisa ter a conta ativa (access)
     *
     * @return 
     */
    public function __construct(\App\Reports\TemplateReport $pdf)
    {
        $this->middleware(['middleware' => 'auth']);
        $this->middleware(['middleware' => 'hasaccess']);

        $this->pdf = $pdf;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('paciente-index')) {
            abort(403, 'Acesso negado.');
        }

        $pacientes = new Paciente;

        // filtros
        if (request()->has('nome')){
            $pacientes = $pacientes->where('nome', 'like', '%' . request('nome') . '%');
        }

        if (request()->has('nomeMae')){
            $pacientes = $pacientes->where('nomeMae', 'like', '%' . request('nomeMae') . '%');
        }

        if (request()->has('unidade')){
            $pacientes = $pacientes->whereHas('unidade', function ($query) {
                                                $query->where('descricao', 'like', '%' . request('unidade') . '%');
                                            });
        }

        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $pacientes = $pacientes->whereHas('unidade', function ($query) {
                                                    $query->where('distrito_id', '=', request('distrito_id'));
                                                });                
            }
        }

        if (request()->has('idadeMin')){
            if (request('idadeMin') != ""){
                $pacientes = $pacientes->where('idade', '>=', request('idadeMin'));
            }
        } 

        if (request()->has('idadeMax')){
            if (request('idadeMax') != ""){
                $pacientes = $pacientes->where('idade', '<=', request('idadeMax'));
            }
        }

        // if (request()->has('idadeMin')){
        //     $pacientes = $pacientes->where('idade', '>=', request('idadeMin'));
        // }

        // if (request()->has('idadeMax')){
        //     $pacientes = $pacientes->where('idade', '<=', request('idadeMax'));
        // }

        // ordena
        $pacientes = $pacientes->orderBy('nome', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $pacientes = $pacientes->paginate(session('perPage', '5'))->appends([          
            'nome' => request('nome'),
            'nomeMae' => request('nomeMae'),
            'unidade' => request('unidade'),
            'distrito_id' => request('distrito_id'),
            'idadeMin' => request('idadeMin'),
            'idadeMax' => request('idadeMax'),    
            ]);

        // tabelas auxiliares usadas pelo filtro
        $distritos = Distrito::orderBy('nome', 'asc')->get();

        return view('pacientes.index', compact('pacientes', 'perpages', 'distritos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('paciente-create')) {
            abort(403, 'Acesso negado.');
        }

        $comorbidades = Comorbidade::orderBy('descricao', 'asc')->get();

        $sintomas = SintomasCadastro::orderBy('descricao', 'asc')->get();

        return view('pacientes.create', compact('comorbidades', 'sintomas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nome' => 'required',
            'nomeMae' => 'required',
            'nascimento' => 'required|date_format:d/m/Y',
            'unidade_id' => 'required',
            'tomouVacina' => 'required',
            'cel1' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'inicioSintomas' => 'required|date_format:d/m/Y',
        ],
        [
            'nome.required' => 'O nome do paciente é obrigatório',
            'nomeMae.required' => 'O nome da mãe do paciente é obrigatório',
            'nascimento.required' => 'A data de nascimento é obrigatória',
            'cel1.required' => 'É obrigatório digitar um número de celular para contato',
            'unidade_id.required' => 'Preencha o campo de unidade',
            'tomouVacina.required' => 'Escolha uma opção',
            'inicioSintomas.required' => 'O início dos sintomas deve ser preenchido',
        ]);


        $paciente = $request->all();

        $user = Auth::user();

        // calcula a idade
        $paciente['idade'] = Carbon::createFromFormat('d/m/Y', $paciente['nascimento'])->age;

        //salva o usuario que fez o cadastro
        $paciente['user_id'] = $user->id;

        // coloca a situação do monitoramento como não monitorado
        $paciente['monitorando'] = 'n';

        // ajuste de data de nascimento
        $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('nascimento'))->format('Y-m-d');
        $paciente['nascimento'] =  $dataFormatadaMysql;

        // ajuste de data de inicio dos Sintomas
        $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('inicioSintomas'))->format('Y-m-d');
        $paciente['inicioSintomas'] =  $dataFormatadaMysql;

        $novoPaciente = Paciente::create($paciente);

        //salva as comorbidades
        if(isset($paciente['comorbidades']) && count($paciente['comorbidades'])){
            foreach ($paciente['comorbidades'] as $key => $value) {
               $novoPaciente->comorbidades()->attach($value);
            }
        }

        //salva os sintomas iniciais
        if(isset($paciente['sintomasiniciais']) && count($paciente['sintomasiniciais'])){
            foreach ($paciente['sintomasiniciais'] as $key => $value) {
               $novoPaciente->sintomasCadastros()->attach($value);
            }
        }

        Session::flash('create_paciente', 'Paciente foi cadastrado com sucesso!');

        //return redirect(route('pacientes.index'));

        return Redirect::route('pacientes.edit', $novoPaciente->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('paciente-show')) {
            abort(403, 'Acesso negado.');
        }

        $paciente = Paciente::findOrFail($id);

        $monitoramentos = Monitoramento::where('paciente_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('pacientes.show', compact('paciente', 'monitoramentos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('paciente-edit')) {
            abort(403, 'Acesso negado.');
        }

        $paciente = Paciente::findOrFail($id);

        $comorbidades = Comorbidade::orderBy('descricao', 'asc')->get();

        $sintomas = SintomasCadastro::orderBy('descricao', 'asc')->get();

        $sintomas_monitoramento = Sintoma::orderBy('descricao', 'asc')->get();

        $doencas = DoencasBase::orderBy('descricao', 'asc')->get();

        $monitoramentos = Monitoramento::where('paciente_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('pacientes.edit', compact('paciente', 'comorbidades', 'sintomas', 'doencas', 'sintomas_monitoramento', 'monitoramentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nome' => 'required',
            'nomeMae' => 'required',
            'nascimento' => 'required|date_format:d/m/Y',
            'unidade_id' => 'required',
            'tomouVacina' => 'required',
            'cel1' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'inicioSintomas' => 'required|date_format:d/m/Y',
        ],
        [
            'nome.required' => 'O nome do paciente é obrigatório',
            'nomeMae.required' => 'O nome da mãe do paciente é obrigatório',
            'nascimento.required' => 'A data de nascimento é obrigatória',
            'cel1.required' => 'É obrigatório digitar um número de celular para contato',
            'unidade_id.required' => 'Preencha o campo de unidade',
            'tomouVacina.required' => 'Escolha uma opção',
            'inicioSintomas.required' => 'O início dos sintomas deve ser preenchido',
        ]);

        $paciente = Paciente::findOrFail($id);

        $paciente_input = $request->all();

        $user = Auth::user();

        // calcula a idade
        $paciente_input['idade'] = Carbon::createFromFormat('d/m/Y', $paciente_input['nascimento'])->age;

       //salva o usuario que fez o cadastro
        $paciente_input['user_id'] = $user->id;

        // coloca a situação do monitoramento como não monitorado
        $paciente_input['monitorando'] = 's';

        // ajuste de data de nascimento
        $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('nascimento'))->format('Y-m-d');
        $paciente_input['nascimento'] =  $dataFormatadaMysql;

        // ajuste de data de inicio dos Sintomas
        $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('inicioSintomas'))->format('Y-m-d');
        $paciente_input['inicioSintomas'] =  $dataFormatadaMysql;
            
        // remove todos os comorbidades
        $comorbidades = $paciente->comorbidades;
        if(count($comorbidades)){
            foreach ($comorbidades as $key => $value) {
               $paciente->comorbidades()->detach($value->id);
            }
        }

        // vincula as comorbidades
        if(isset($paciente_input['comorbidades']) && count($paciente_input['comorbidades'])){
            foreach ($paciente_input['comorbidades'] as $key => $value) {
               $paciente->comorbidades()->attach($value);
            }
        }

        // remove todos os sintomas do cadastro (sintomas iniciais)
        $sintomasCadastros = $paciente->sintomasCadastros;
        if(count($sintomasCadastros)){
            foreach ($sintomasCadastros as $key => $value) {
               $paciente->sintomasCadastros()->detach($value->id);
            }
        }

        // vincula as sintomas do cadastro (sintomas iniciais)
        if(isset($paciente_input['sintomasiniciais']) && count($paciente_input['sintomasiniciais'])){
            foreach ($paciente_input['sintomasiniciais'] as $key => $value) {
               $paciente->sintomasCadastros()->attach($value);
            }
        }

        // remove todos os sintomas do cadastro (sintomas iniciais)
        $doencasBases = $paciente->doencasBases;
        if(count($doencasBases)){
            foreach ($doencasBases as $key => $value) {
               $paciente->doencasBases()->detach($value->id);
            }
        }

        // vincula as sintomas do cadastro (sintomas iniciais)
        if(isset($paciente_input['doencas']) && count($paciente_input['doencas'])){
            foreach ($paciente_input['doencas'] as $key => $value) {
               $paciente->doencasBases()->attach($value);
            }
        }


        $paciente->update($paciente_input);
        
        Session::flash('edited_paciente', 'Cadastro do paciente foi alterado com sucesso!');

        return redirect(route('pacientes.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('paciente-delete')) {
            abort(403, 'Acesso negado.');
        }
        
        Paciente::findOrFail($id)->delete();

        Session::flash('deleted_paciente', 'Paciente enviado para lixeira!');

        return redirect(route('pacientes.index'));
    }
}
