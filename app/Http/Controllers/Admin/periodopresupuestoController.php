<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\periodopresupuesto;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use DB;


class periodopresupuestoController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodo = periodopresupuesto::latest()->paginate(5);
        //$periodos=DB::table('periodopresupuesto')->paginate(10); 
        return view('admin.periodop.index',compact('periodo')) ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.periodop.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'Fecha' => 'required',
            'Descripcion' => 'required',
        ]);
        periodopresupuesto::create($request->all());

        return redirect('admin/periodop')->with('success','Periodo created successfully');
       
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $periodo = periodopresupuesto::find($id);
        return view('admin.periodop.show',compact('periodo'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periodo = periodopresupuesto::find($id);
        return view('admin.periodop.edit',compact('periodo'));
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
        request()->validate(['Fecha' => 'required','Descripcion' => 'required',]);
        periodopresupuesto::find($id)->update($request->all());
        return redirect('admin/periodop')->with('success','Periodo updated successfully');
      
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        periodopresupuesto::find($id)->delete();
        return redirect('admin/periodop')->with('success','Periodo deleted successfully');
    }


}

