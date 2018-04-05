<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Permisos;
use DB;

class PermisosController extends Controller {

    /* public function index(Request $des){
		$alldata = DB::table('tipodocumento')->select('IdTipoDocumento', 'Descripcion')->orderby('IdTipoDocumento','DESC');            
        return $alldata;
    }*/

/**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $permisos = Permisos::latest()->paginate(5);
		$permissions = DB::table('permissions')->select('id','name','slug','description')->orderby('id','asc')->paginate(8);  
        return view('admin.permisos.index',compact('permissions'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permisos.create');
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
            'name' => 'required',
            'slug' => 'required',
            'description'=>'required',
        ]);
        Permisos::create($request->all());
        return redirect('admin/permisos')->with('success','permission created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
       // $permissions = Permisos::find($id);
       // return view('admin/permisos/show',compact('permissions'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permisos::find($id);
        return view('admin/permisos/edit',compact('permission'));
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
        request()->validate([
            'name' => 'required',
            'slug' => 'required',
            'description'=>'required',
        ]);
        Permisos::find($id)->update($request->all());
        return redirect()->route('admin/permisos/index')->with('success','permission updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permisos::find($id)->delete();
        return redirect('admin/permisos')->with('success','permission deleted successfully');
    }

}