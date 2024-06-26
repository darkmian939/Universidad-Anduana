<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $teacher = Teacher::where('email', $request->email)->first();

        if (!$teacher || !Hash::check($request->password, $teacher->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas. Verifica tu email y contraseña.',
                'status' => 401
            ], 401);
        }

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'teacher' => $teacher,
            'status' => 200
        ], 200);
    }

    public function index()
    {
        $teachers = Teacher::all();

        if ($teachers->isEmpty()) {
            return response()->json([
                'message' => 'No hay profesores registrados',
                'status' => 200
            ], 200);
        }

        return response()->json($teachers, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => 'required|email|unique:teachers',
            'password' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $passwordHashed = Hash::make($request->password);

        $teacher = Teacher::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => $passwordHashed,
        ]);

        return response()->json([
            'message' => 'Profesor creado exitosamente',
            'teacher' => $teacher,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'message' => 'Profesor no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'teacher' => $teacher,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'message' => 'Profesor no encontrado',
                'status' => 404
            ], 404);
        }

        $teacher->delete();

        return response()->json([
            'message' => 'Profesor eliminado correctamente',
            'status' => 200
        ], 200);
    }

}
