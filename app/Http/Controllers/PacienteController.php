<?php

namespace App\Http\Controllers;

use App\Paciente;
use App\Distrito;
use App\DoencasBase;
use App\SintomasCadastro;
use App\Sintoma;
use App\Rtpcr;
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

        if (request()->has('situacao')){
            if (request('situacao') != ""){
                $pacientes = $pacientes->where('monitorando', '=', request('situacao'));
            }
        }

        if (request()->has('testeRapido')){
            if (request('testeRapido') != ""){
                $pacientes = $pacientes->where('testeRapido', '=', request('testeRapido'));
            }
        }

        if (request()->has('rtpcr_id')){
            if (request('rtpcr_id') != ""){
                $pacientes = $pacientes->where('rtpcr_id', '=', request('rtpcr_id'));
            }
        }

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
            'rtpcr_id' => request('rtpcr_id'),    
            'testeRapido' => request('testeRapido'),    
            ]);

        // tabelas auxiliares usadas pelo filtro
        $distritos = Distrito::orderBy('nome', 'asc')->get();

        $rtpcrs = Rtpcr::orderBy('id', 'desc')->get();

        return view('pacientes.index', compact('pacientes', 'perpages', 'distritos', 'rtpcrs'));
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
            'testeRapido' => 'required',
            'cel1' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'sintomasiniciais' => 'required',
            'comorbidades' => 'required',
            'inicioSintomas' => 'required|date_format:d/m/Y',
        ],
        [
            'nome.required' => 'O nome do paciente é obrigatório',
            'nomeMae.required' => 'O nome da mãe do paciente é obrigatório',
            'nascimento.required' => 'A data de nascimento é obrigatória',
            'cel1.required' => 'É obrigatório digitar um número de celular para contato',
            'unidade_id.required' => 'Preencha o campo de unidade',
            'testeRapido.required' => 'Escolha uma opção',
            'sintomasiniciais.required' => 'Escolha pelo menos um sintoma',
            'comorbidades.required' => 'Escolha pelo menos uma comorbidade',
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

        // coloca a situacao do rt-pcr que é um teste, defaul é 1, não monitorado
        // então indica que ainda não existe essa informação no cadastro do paciente
        $paciente['rtpcr_id'] = 1;

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

        $monitoramentos = Monitoramento::where('paciente_id', '=', $id)->orderBy('id', 'desc')->get();

        $rtpcrs = Rtpcr::where('id', '>', 1)->orderBy('id', 'desc')->get();

        return view('pacientes.edit', compact('paciente', 'comorbidades', 'sintomas', 'sintomas_monitoramento', 'monitoramentos', 'rtpcrs'));
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
            'testeRapido' => 'required',
            'cel1' => 'required',
            'cep' => 'required',
            'logradouro' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
            'sintomasiniciais' => 'required',
            'comorbidades' => 'required',
            'inicioSintomas' => 'required|date_format:d/m/Y',
        ],
        [
            'nome.required' => 'O nome do paciente é obrigatório',
            'nomeMae.required' => 'O nome da mãe do paciente é obrigatório',
            'nascimento.required' => 'A data de nascimento é obrigatória',
            'cel1.required' => 'É obrigatório digitar um número de celular para contato',
            'unidade_id.required' => 'Preencha o campo de unidade',
            'testeRapido.required' => 'Escolha uma opção',
            'sintomasiniciais.required' => 'Escolha pelo menos um sintoma',
            'comorbidades.required' => 'Escolha pelo menos uma comorbidade',
            'inicioSintomas.required' => 'O início dos sintomas deve ser preenchido',
        ]);

        $paciente = Paciente::findOrFail($id);

        $paciente_input = $request->all();

        // calcula a idade
        $paciente_input['idade'] = Carbon::createFromFormat('d/m/Y', $paciente_input['nascimento'])->age;

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


        $paciente->update($paciente_input);
        
        Session::flash('edited_paciente', 'Cadastro do paciente foi alterado com sucesso!');

        // $request->session()->flash('edited_paciente', 'Cadastro do paciente foi alterado com sucesso!');

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


    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('sintoma-export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=Pacientes_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $pacientes = DB::table('pacientes');

        // joins
        $pacientes = $pacientes->join('unidades', 'unidades.id', '=', 'pacientes.unidade_id');
        $pacientes = $pacientes->join('rtpcrs', 'rtpcrs.id', '=', 'pacientes.rtpcr_id');
        $pacientes = $pacientes->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');
        $pacientes = $pacientes->join('users', 'users.id', '=', 'pacientes.user_id');

        // select
        $pacientes = $pacientes->select(
            'pacientes.nome',
            'pacientes.nomeMae',
            DB::raw('DATE_FORMAT(pacientes.nascimento, \'%d/%m/%Y\') AS nascimento'),            
            
            'pacientes.idade',
            'unidades.descricao as unidade',
            'distritos.nome as distrito',
            

            DB::raw('DATE_FORMAT(pacientes.ultimoMonitoramento, \'%d/%m/%Y\') AS ultimo_monitoramento'),
            

            DB::raw('DATE_FORMAT(pacientes.inicioSintomas, \'%d/%m/%Y\') AS inicio_sintomas'),

            'rtpcrs.descricao as RTPCR',
            'rtpcrs.descricao as teste_rapido',


            DB::raw('(select group_concat(b.descricao) from paciente_sintomas_cadastro a inner join sintomas_cadastros b on a.sintomas_cadastro_id =b.id where a.paciente_id = pacientes.id) as sintomas_iniciais'),

            DB::raw('( select group_concat(b.descricao) from comorbidade_paciente a inner join comorbidades b on a.comorbidade_id = b.id where a.paciente_id = pacientes.id) as comorbidades'),

            'pacientes.monitorando as monitorando',

            DB::raw("

                (CASE
                    WHEN pacientes.monitorando = 'nao' THEN 'Não Monitorado'
                    WHEN pacientes.monitorando = 'm24' THEN 'Monitorar em 24hs'
                    WHEN pacientes.monitorando = 'm48' THEN 'Monitorar em 48hs'
                    WHEN pacientes.monitorando = 'enc' THEN 'Encaminhado'
                    WHEN pacientes.monitorando = 'alta' THEN 'Alta'
                    ELSE 'erro'
                END) as situacao

                "),

            'pacientes.cel1', 
            'pacientes.cel2', 

            'pacientes.cep', 
            'pacientes.logradouro', 
            'pacientes.bairro', 
            'pacientes.numero', 
            'pacientes.complemento', 
            'pacientes.cidade', 
            'pacientes.uf', 

            'users.name as funcionario',
            DB::raw('DATE_FORMAT(pacientes.created_at, \'%d/%m/%Y\') AS data'),
            DB::raw('DATE_FORMAT(pacientes.created_at, \'%H:%i\') AS hora'),

            'pacientes.notas', 

        );

        //filtros
        if (request()->has('nome')){
            $pacientes = $pacientes->where('pacientes.nome', 'like', '%' . request('nome') . '%');
        }

        if (request()->has('nomeMae')){
            $pacientes = $pacientes->where('pacientes.nomeMae', 'like', '%' . request('nomeMae') . '%');
        }

        if (request()->has('unidade')){
            $pacientes = $pacientes->where('unidades.descricao', 'like', '%' . request('unidade') . '%');
        }

        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $pacientes = $pacientes->where('unidades.distrito_id', '=', request('distrito_id'));
            }
        }

        if (request()->has('rtpcr_id')){
            if (request('rtpcr_id') != ""){
                $pacientes = $pacientes->where('pacientes.rtpcr_id', '=', request('rtpcr_id'));
            }
        }

        if (request()->has('idadeMin')){
            if (request('idadeMin') != ""){
                $pacientes = $pacientes->where('pacientes.idade', '>=', request('idadeMin'));
            }
        } 

        if (request()->has('idadeMax')){
            if (request('idadeMax') != ""){
                $pacientes = $pacientes->where('pacientes.idade', '<=', request('idadeMax'));
            }
        }

        if (request()->has('situacao')){
            if (request('situacao') != ""){
                $pacientes = $pacientes->where('pacientes.monitorando', '=', request('situacao'));
            }
        }

        if (request()->has('testeRapido')){
            if (request('testeRapido') != ""){
                $pacientes = $pacientes->where('pacientes.testeRapido', '=', request('testeRapido'));
            }
        }

        $pacientes = $pacientes->orderBy('nome', 'asc');

        $list = $pacientes->get()->toArray();

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

       $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            fputs($FH, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            foreach ($list as $row) {
                fputcsv($FH, $row, chr(9));
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }    

    /**
     * Função de autocompletar para ser usada pelo typehead
     *
     * @param  
     * @return json
     */
    public function autocomplete(Request $request)
    {
        $pacientes = DB::table('pacientes');


        // select
        $pacientes = $pacientes->select(
            'pacientes.nome as text', 
            'pacientes.id as value',
            'pacientes.nomeMae as mae',
            DB::raw('DATE_FORMAT(pacientes.nascimento, \'%d/%m/%Y\') AS nascimento'),


            DB::raw("

                (CASE
                    WHEN pacientes.monitorando = 'nao' THEN 'Não Monitorado'
                    WHEN pacientes.monitorando = 'm24' THEN 'Monitorar em 24hs'
                    WHEN pacientes.monitorando = 'm48' THEN 'Monitorar em 48hs'
                    WHEN pacientes.monitorando = 'enc' THEN 'Encaminhado'
                    WHEN pacientes.monitorando = 'alta' THEN 'Alta'
                    ELSE 'erro'
                END) as situacao

                "),


            'pacientes.idade as idade',
        );
        
        //where
        $pacientes = $pacientes->where("pacientes.nome","LIKE","%{$request->input('query')}%");



        //get
        $pacientes = $pacientes->get();

        return response()->json($pacientes, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }

}
