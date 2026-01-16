<?php

namespace App\Http\Controllers;

use App\Events\MyEvent;
use App\Http\Helpers\CommonUtils;
use App\Http\Helpers\OracleRestErp;
use App\Http\Helpers\RequestNit;
use App\Http\Helpers\SendEmailRequestNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

use function PHPSTORM_META\type;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rol = Auth::User()->rol;

        if ($rol->role_id == 1) {

            $request_status = DB::table('users')->where('deleted_at', null)->select('status', DB::Raw('count(status) AS count'))->groupBy('users.status')->get();
            return view('home', [
                'request_status' => $request_status,
            ]);
        }

        if ($rol->role_id == 2 || $rol->role_id == 3) {

            $user = DB::table('relationship')
                ->leftJoin('users', 'users.id', '=', 'relationship.user_id')
                ->where('relationship.user_assigne_id',  Auth::user()->id)
                ->where('relationship.deleted_at', '=', null)
                ->select('users.number_id', 'users.document_type')
                ->first();

            $number_id  = $user == null ? Auth::user()->number_id : $user->number_id;
            $documentType = $user == null ? Auth::user()->document_type : $user->document_type;

            $document = ($documentType == "NIT") ? RequestNit::getNit($number_id) : $number_id;

            $documentCandidates = [(string) $document];
            $normalizedNumberId = preg_replace('/\D+/', '', (string) $number_id);

            if ($documentType == "NIT") {
                if ($normalizedNumberId !== '') {
                    $withDv = RequestNit::getNit($normalizedNumberId);
                    if ($withDv && !in_array($withDv, $documentCandidates, true)) {
                        $documentCandidates[] = $withDv;
                    }
                }

                if (str_contains($document, '-')) {
                    $withoutDv = str_replace('-', '', $document);
                    if (!in_array($withoutDv, $documentCandidates, true)) {
                        $documentCandidates[] = $withoutDv;
                    }
                }
            }

            $SupplierNumber = null;
            Log::info(__METHOD__ . '. TaxpayerId candidates', [
                'user_id' => Auth::user()->id,
                'document_type' => $documentType,
                'number_id' => $number_id,
                'candidates' => $documentCandidates,
            ]);
            foreach ($documentCandidates as $candidate) {
                $params = [
                    'q'        => "(TaxpayerId = '{$candidate}')",
                    'limit'    => '200',
                    'fields'   => 'SupplierNumber',
                    'onlyData' => 'true'
                ];

                $response = OracleRestErp::procurementGetSuppliers($params);
                $res = $response->json();

                Log::info(__METHOD__ . '. Supplier lookup', [
                    'candidate' => $candidate,
                    'status' => $response->status(),
                    'count' => is_array($res) && array_key_exists('count', $res) ? $res['count'] : null,
                ]);

                if (is_array($res) && !empty($res['items']) && isset($res['items'][0]['SupplierNumber'])) {
                    $SupplierNumber = (int) $res['items'][0]['SupplierNumber'];
                    break;
                }
            }

            if ($SupplierNumber === null) {
                return redirect()->route('error404');
            }

            return view('home', [
                'SupplierNumber' => $SupplierNumber,
                'number_id' => $number_id
            ]);
        }

        if ($rol->role_id == 4) {
            return view('home');
        }
    }

    public function docs()
    {
        return view('auth/docs/index');
    }
}
