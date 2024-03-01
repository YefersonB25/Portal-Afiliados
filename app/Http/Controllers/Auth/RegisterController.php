<?php

namespace App\Http\Controllers\Auth;

use App\Events\MessageSentPrivate;
use App\Http\Controllers\Controller;
use App\Http\Helpers\SendEmailRequestNotification;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Pusher\Pusher;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**VerifiesEmails
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'indisposable'],
            Rule::unique('users', 'email')->where(function ($query) {
                return $query->whereNull('deleted_at')->orWhereNotNull('deleted_at');
            }),
            'number_id' => ['required', 'numeric', 'unique:users'],
            'phone' => ['required', 'numeric'],
            'document_type' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'captcha' => ['required', 'captcha:' . request('key') . ',math']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // protected function create(array $data)
    // {

    //     $roles = Role::get();

    //     $id = User::insertGetId([
    //         'name'                  => $data['name'],
    //         'email'                 => $data['email'],
    //         'number_id'        => $data['number_id'],
    //         'document_type'          => $data['document_type'],
    //         'phone'              => $data['phone'],
    //         'status'                => 'NUEVO',
    //         'password'              => Hash::make($data['password']),
    //         'created_at' => Carbon::now(),
    //         'updated_at' => Carbon::now(),

    //     ]);

    //     $usuario = User::findOrFail($id);
    //     $usuario->roles()->sync($roles[1]->id);

    //     //? Guardamos los archivos cargados y capturamos la ruta
    //     if (!empty($data['photo'])) {

    //         $profileImage = $data['photo'];
    //         // $user = Auth::user();

    //         $folderPath = 'public/profile/image';
    //         $randomFileName = $data['number_id'] . '.' . $profileImage->getClientOriginalExtension();
    //         $imagePath = 'profile/image/' . $randomFileName;

    //         // Validar y crear directorio si no existe
    //         if (!Storage::exists($folderPath)) {
    //             Storage::makeDirectory($folderPath);
    //         }

    //         // Storage::put($imagePath, $profileImage);
    //         Storage::putFileAs($folderPath, $profileImage, $randomFileName);

    //         // $carpetaphoto = "proveedores/$id/perfil";
    //         // Storage::putFileAs("public/$carpetaphoto", $data['photo'], 'photo_perfil.' . $extensionPerfil);
    //     }

    //     if (!empty($data['photo_id'])) {

    //         $profilepdf = $data['photo_id'];

    //         $folderPath = 'public/documet/pdf';
    //         $randomFileName = $data['number_id'] . '.' . $profilepdf->getClientOriginalExtension();
    //         $pdfPath = 'profile/image/' . $randomFileName;

    //          // Validar y crear directorio si no existe
    //          if (!Storage::exists($folderPath)) {
    //             Storage::makeDirectory($folderPath);
    //         }

    //         // Storage::put($imagePath, $profileImage);
    //         Storage::putFileAs($folderPath, $profilepdf, $randomFileName);

    //         // $carpetaidentif = "proveedores/$id/identificacion";
    //         // Storage::putFileAs("public/$carpetaidentif", $data['photo_id'], 'photo_documento.' . $extensionIdentif);
    //     }

    //     //? Actualizamos el usuario para agregarle la ruta de los archivos en los campos asignados
    //     if (!empty($data['photo']) && !empty($data['photo_id'])) {
    //         User::where('id', $id)
    //             ->update([
    //                 'photo'                 => "$imagePath",
    //                 'photo_id'   => "$pdfPath",
    //             ]);
    //     }

    //     if (!empty($data['photo'])) {

    //         User::where('id', $id)
    //             ->update([
    //                 'photo'   => "$imagePath",
    //             ]);
    //     }

    //     if (!empty($data['photo_id'])) {

    //         User::where('id', $id)
    //             ->update([
    //                 'photo_id'   => "$pdfPath",
    //             ]);
    //     }
    // }

    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name'           => $data['name'],
                'email'          => $data['email'],
                'number_id'      => $data['number_id'],
                'document_type'  => $data['document_type'],
                'phone'          => $data['phone'],
                'status'         => 'NUEVO',
                'password'       => Hash::make($data['password']),
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]);

            $roles = Role::get();
            $user->roles()->sync([$roles[1]->id]);

            $imagePath = $this->storeFile(isset($data['photo']) ? $data['photo'] : '', 'profile/image', $user->number_id);
            $pdfPath = $this->storeFile(isset($data['photo_id']) ? $data['photo_id'] : '', 'documet/pdf', $user->number_id);

            $user->update([
                'photo_id' => $pdfPath,
                'photo'    => $imagePath
            ]);


            DB::commit();

            // Redirigir al usuario al formulario de inicio de sesión
            return redirect()->route('login')->with([
                'autoLoginData' => [
                    'email'    => $user->email,
                    'password' => $data['password'],
                ]
            ]);

            // return $user;
        } catch (\Exception $e) {
            // DB::rollback();
            Log::error("Error en la importación: " . $e->getMessage());

            // Manejar la excepción, por ejemplo, registrando un error.
            // return null;
        }
    }

    private function storeFile($file, $folder, $userId)
    {
        if (!empty($file)) {
            $folderPath = "public/$folder";
            $extension = $file->getClientOriginalExtension();
            $randomFileName = $userId . '.' . $extension;
            $filePath = "$folder/$randomFileName";

            if (!Storage::exists($folderPath)) {
                Storage::makeDirectory($folderPath);
            }

            Storage::putFileAs($folderPath, $file, $randomFileName);

            return $filePath;
        }

        return null;
    }


    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        event(new Registered($this->create($request->all())));

        // self::notificationActionPusher();
        // SendEmailRequestNotification::sendEmail($request->name);

        return redirect()->route('login')->with('error', 'Los datos de la cuenta aun no han sido validados.');
    }

    function notificationActionPusher()
    {

        $app_id = config('broadcasting.connections.pusher.app_id');
        $app_key = config('broadcasting.connections.pusher.key');
        $app_secret = config('broadcasting.connections.pusher.secret');
        $app_cluster = config('broadcasting.connections.pusher.options.cluster');

        $pusher = new Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);

        $pusher->trigger('my-channel', 'MyEvent', 'Nuevo usuario registrado');
    }
}
