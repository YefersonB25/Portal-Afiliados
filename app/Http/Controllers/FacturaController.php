<?php

namespace App\Http\Controllers;

use App\Http\Helpers\OracleRestErp;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\Relationship;
use App\Models\User;
use Faker\Core\Number;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FacturaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:/facturas')->only('index');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // $user =  DB::table('users')->select('number_id')->where('id', $request->id)->first();
            // $number_id = $user->number_id;

            // $params = [
            //     'q'        => "(TaxpayerId = '{$number_id}')",
            //     'limit'    => '200',
            //     'fields'   => 'SupplierNumber',
            //     'onlyData' => 'true'
            // ];

            // $response = OracleRestErp::procurementGetSuppliers($params);

            // $res = $response->json();

            // //? Validanos que nos traiga el proveedor
            // if ($res['count'] == 0) {
            //     // return response()->json(['message' => 'No se encontro el proveedor'], 404);
            //     session()->flash('message', 'No se encontro el proveedor');
            //     return back();
            // }
            // $SupplierNumber =  (integer)$res['items'][0]['SupplierNumber'];
            // , ['SupplierNumber' => $SupplierNumber, 'number_id' => $number_id]
                return view('facturas.index');
        } catch (\Throwable $th) {
            Log::error(__METHOD__ . '. General error: ' . $th->getMessage());
             return  $th->getMessage();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('facturas.crear');
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
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

        // Blog::create($request->all());

        return redirect()->route('facturas.index');
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
    // public function edit(Blog $blog)
    // {
    //     return view('facturas.editar', compact('blog'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Blog $blog)
    // {
    //     request()->validate([
    //         'titulo' => 'required',
    //         'contenido' => 'required',
    //     ]);

    //     $blog->update($request->all());

    //     return redirect()->route('facturas.index');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Blog $blog)
    // {
    //     $blog->delete();

    //     return redirect()->route('facturas.index');
    // }
}
