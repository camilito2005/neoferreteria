<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
// use Hash;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    // protected $redirectTo = '/agregar';  // Personaliza la redirección después del inicio de sesión


    public function showLoginForm()
    {
        return view('software.auth.login-registro');
    }
    //     public function login(Request $request)
    // {
    //     // Validar los datos del formulario
    //     $this->validate($request, [
    //         $this->username() => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     // Intentar autenticar al usuario
    //     if (Auth::attempt($request->only([$this->username(), 'password']))) {
    //         // El usuario se ha autenticado con éxito
    //         return redirect()->intended($this->redirectPath());
    //     }

    //     // La autenticación ha fallado, redirigir de nuevo al formulario de inicio de sesión
    //     return redirect()->back()
    //         ->withInput($request->only($this->username(), 'remember'))
    //         ->withErrors(['loginError' => 'Credenciales incorrectas']);
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['Las credenciales proporcionadas son incorrectas.'],
    //         ]);
    //     }

    //     // Verifica el rol del usuario
    //     if ($user->rol === 'admin') {
    //         // include ('./ferrinventadso/public')
    //         // Usuario con rol de administrador
    //         header('Location: ./ferrinventadso/public');
    //         // Realiza acciones específicas para administradores
    //     } elseif ($user->rol === 'user') {
    //         // Usuario con rol de usuario regular
    //         // Realiza acciones específicas para usuarios regulares
    //     }

    //     $token = $user->createToken('authToken')->plainTextToken;

    //     return response()->json(['token' => $token]);
    // }


    public function login(Request $request)
{
    $messages = [
        'email.exists' => 'Correo o usuario no registrado.',
        'password' => 'Contraseña incorrecta.',
    ];

    $request->validate([
        'email' => 'required|exists:users,email',
        'password' => 'required',
    ], $messages);

    $datos = $request->only('email', 'password');

    if (Auth::attempt($datos)) {
   
    

        if (Auth::attempt($datos)) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.inicio');
            } elseif (Auth::user()->isEmpleado()) {
                return redirect()->route('agregar');
            } elseif (Auth::user()->yo()) {
                return redirect()->route('yo');
            } else {
                return redirect()->route('shop');
                // header('Location: /ferrinventadso/public/');
            }
        }
    }

    return back()->withErrors(['email' => 'Correo o usuario no registrado', 'password' => 'Contraseña incorrecta']);
}


    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            
            
        ];
    
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,usuario,empleado',
        ], $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'identificador' => $request->identificador,
        ]);
        if (Auth::login($user)) {
            return redirect()->route('shop');
        }
    
        return back()->withErrors(['email' => 'Este correo ya existe']);
    }
    
}
