<?php

namespace App\Http\Controllers;

use App\Sintoma;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class SintomaController extends Controller
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
        if (Gate::denies('sintoma-index')) {
            abort(403, 'Acesso negado.');
        }

        $sintomas = new Sintoma;

        // ordena
        $sintomas = $sintomas->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $sintomas = $sintomas->paginate(session('perPage', '5'));

        return view('sintomas.index', compact('sintomas', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('sintoma-create')) {
            abort(403, 'Acesso negado.');
        }

        return view('sintomas.create');
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
          'descricao' => 'required',
        ]);

        $sintoma = $request->all();

        Sintoma::create($sintoma); //salva

        Session::flash('create_sintoma', 'Sintoma cadastrado com sucesso!');

        return redirect(route('sintomas.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('sintoma-show')) {
            abort(403, 'Acesso negado.');
        }

        $sintoma = Sintoma::findOrFail($id);

        return view('sintomas.show', compact('sintoma'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('sintoma-edit')) {
            abort(403, 'Acesso negado.');
        }

        $sintoma = Sintoma::findOrFail($id);

        return view('sintomas.edit', compact('sintoma'));
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
          'descricao' => 'required',
        ]);

        $sintoma = Sintoma::findOrFail($id);
            
        $sintoma->update($request->all());
        
        Session::flash('edited_sintoma', 'Sintoma alterado com sucesso!');

        return redirect(route('sintomas.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('sintoma-delete')) {
            abort(403, 'Acesso negado.');
        }

        Sintoma::findOrFail($id)->delete();

        Session::flash('deleted_sintoma', 'Sintoma excluido!');

        return redirect(route('sintomas.index'));
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
            ,   'Content-Disposition' => 'attachment; filename=Sintomas_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $sintomas = DB::table('sintomas');

        $sintomas = $sintomas->select('descricao');

        $sintomas = $sintomas->orderBy('descricao', 'asc');

        $list = $sintomas->get()->toArray();

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
     * Exportação para pdf
     *
     * @param  
     * @return 
     */
    public function exportpdf()
    {
        if (Gate::denies('sintoma-export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $sintomas = DB::table('sintomas');

        $sintomas = $sintomas->select('descricao');


        $sintomas = $sintomas->orderBy('descricao', 'asc');    


        $sintomas = $sintomas->get();

        foreach ($sintomas as $sintoma) {
            $this->pdf->Cell(186, 6, utf8_decode($sintoma->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'Sintomas_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }  
}
