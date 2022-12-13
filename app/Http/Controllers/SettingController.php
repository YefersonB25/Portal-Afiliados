<?php

namespace App\Http\Controllers;

use App\Models\PortalSetting;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        try{
            if ($request->ajax()) {
                $settings = PortalSetting::all();
                return Datatables::of($settings)
                    ->addColumn('actions', function ($query) {
                        return '<form action="'.route('configs.users.destroy',[$query->id]).'" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                    <a href="#" data-toggle="tooltip" data-id="'.$query->id.'" data-placement="top" class="mr-2 oct-show-setting">
                                        <i class="mdi mdi-eye text-info font-24"></i>
                                    </a>
                                    <a href="#" data-toggle="tooltip" data-id="'.$query->id.'" data-placement="top" class="mr-2 oct-edit-setting">
                                        <i class="mdi mdi-square-edit-outline text-success font-24"></i>
                                    </a>
                                </form>';
                            })
                    ->editColumn('val', function($query) {
                        return ($query->isEncrypt == 1) ? '***********' : $query->val;
                    })
                    ->rawColumns(['actions'])
                    ->make(true);
            }else{
                return view('configs.octopus.index');
            }
        }catch(QueryException $ex){
            Log::error('Controller User[Index]. Query BD error: '.$ex->getMessage());
        }catch(Exception $ex){
            Log::error('Controller User[Index]. General error: '.$ex->getMessage());
        }
    }
}
