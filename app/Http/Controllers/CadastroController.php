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

class CadastroController extends Controller
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

        return view('cadastros.index');
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

        return view('cadastros.create', compact('comorbidades', 'sintomas'));
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
            'sintomasiniciais' => 'required',
            'inicioSintomas' => 'required|date_format:d/m/Y',
        ],
        [
            'nome.required' => 'O nome do paciente é obrigatório',
            'nomeMae.required' => 'O nome da mãe do paciente é obrigatório',
            'nascimento.required' => 'A data de nascimento é obrigatória',
            'cel1.required' => 'É obrigatório digitar um número de celular para contato',
            'unidade_id.required' => 'Preencha o campo de unidade',
            'tomouVacina.required' => 'Escolha uma opção',
            'sintomasiniciais.required' => 'Escolha pelo menos um sintoma',
            'inicioSintomas.required' => 'O início dos sintomas deve ser preenchido',
        ]);


        $paciente = $request->all();

        $user = Auth::user();

        // calcula a idade
        $paciente['idade'] = Carbon::createFromFormat('d/m/Y', $paciente['nascimento'])->age;

        //salva o usuario que fez o cadastro
        $paciente['user_id'] = $user->id;

        // coloca a situação do monitoramento como não monitorado
        $paciente['monitorando'] = 'nao';

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

        return redirect(route('cadastros.index'));
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
        if (Gate::denies('paciente-delete')) {
            abort(403, 'Acesso negado.');
        }
    }
}
