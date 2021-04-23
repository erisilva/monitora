<?php

namespace App\Http\Controllers;

use App\Paciente;
use App\DoencasBase;
use App\Comorbidade;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon; // tratamento de datas

use Auth;

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

        $pacientes = new Paciente;

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
        $pacientes = $pacientes->paginate(session('perPage', '5'));

        return view('pacientes.index', compact('pacientes', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comorbidades = Comorbidade::orderBy('descricao', 'asc')->get();

        $doencas = DoencasBase::orderBy('descricao', 'asc')->get();

        return view('pacientes.create', compact('comorbidades', 'doencas'));
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
            'nascimento' => 'required',
            'unidade_id' => 'required',
            'tomouVacina' => 'required',
            'cel1' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'inicioSintomas' => 'required',
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
        $paciente['monitorando'] = 's';

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

        Session::flash('create_paciente', 'paciente cadastrado com sucesso!');

        return redirect(route('pacientes.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
