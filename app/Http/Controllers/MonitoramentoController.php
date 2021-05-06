<?php

namespace App\Http\Controllers;

use App\Monitoramento;
use App\Paciente;
use App\Perpage;

use Carbon\Carbon;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

use Auth;

use Illuminate\Support\Facades\Redirect;

class MonitoramentoController extends Controller
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
        if (Gate::denies('monitoramento-index')) {
            abort(403, 'Acesso negado.');
        }

        $monitoramentos = new Monitoramento;

        // ordena
        $monitoramentos = $monitoramentos->orderBy('id', 'desc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $monitoramentos = $monitoramentos->paginate(session('perPage', '5'));

        return view('monitoramentos.index', compact('monitoramentos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('monitoramento-create')) {
            abort(403, 'Acesso negado.');
        }

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
            'febre' => 'required',
            'diabetico' => 'required',
            'glicemia' => 'required',
            'teste' => 'required',
            'resultado' => 'required',
            'saude' => 'required',
            'familia' => 'required',

        ],
        [
            'febre.required' => 'Campo obrigatório',
            'diabetico.required' => 'Campo obrigatório',
            'glicemia.required' => 'Campo obrigatório',
            'teste.required' => 'Campo obrigatório',
            'resultado.required' => 'Campo obrigatório',
            'saude.required' => 'Campo obrigatório',
            'familia.required' => 'Campo obrigatório',

        ]);

        $monitoramento = $request->all();

        $user = Auth::user();

        //salva o usuario que fez o cadastro
        $monitoramento['user_id'] = $user->id;

        $novoMonitoramento = Monitoramento::create($monitoramento);

        if(isset($monitoramento['sintomasmonitoramento']) && count($monitoramento['sintomasmonitoramento'])){
            foreach ($monitoramento['sintomasmonitoramento'] as $key => $value) {
               $novoMonitoramento->sintomas()->attach($value);
            }
        }        

        $paciente = Paciente::findOrFail($monitoramento['paciente_id']);
        $paciente->ultimoMonitoramento = Carbon::now();
        $paciente->monitorando = 's';
        $paciente->save();


        Session::flash('create_monitoramento', 'Monitoramento cadastrado com sucesso!');

        return Redirect::route('pacientes.edit', $monitoramento['paciente_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('monitoramento-show')) {
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
        if (Gate::denies('monitoramento-edit')) {
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
        if (Gate::denies('monitoramento-delete')) {
            abort(403, 'Acesso negado.');
        }
    }
}
