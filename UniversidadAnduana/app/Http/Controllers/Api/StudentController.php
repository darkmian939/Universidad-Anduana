<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => 'required|email|unique:students',
            'password' => 'required|max:15',
            'nombre_carrera' => 'required|max:255', // Validación para el nombre de la carrera
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $passwordHashed = Hash::make($request->password);

        $student = Student::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => $passwordHashed,
            'nombre_carrera' => $request->nombre_carrera, // Guardar nombre de la carrera
        ]);

        if (!$student) {
            $data = [
                'message' => 'Error al crear el estudiante',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if(!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'password' => 'required|max:15',
            'nombre_carrera' => 'required|max:255', // Validación para el nombre de la carrera
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $student->nombre = $request->nombre;
        $student->apellido = $request->apellido;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->nombre_carrera = $request->nombre_carrera; // Actualizar nombre de la carrera

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'max:255',
            'apellido' => 'max:255',
            'email' => 'email|unique:students,email,' . $id,
            'password' => 'max:15',
            'nombre_carrera' => 'max:255', // Validación para el nombre de la carrera
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombre')) {
            $student->nombre = $request->nombre;
        }

        if ($request->has('apellido')) {
            $student->apellido = $request->apellido;
        }

        if ($request->has('email')) {
            $student->email = $request->email;
        }

        if ($request->has('password')) {
            $student->password = Hash::make($request->password);
        }

        if ($request->has('nombre_carrera')) {
            $student->nombre_carrera = $request->nombre_carrera; // Actualizar nombre de la carrera
        }

        $student->save();

        $data = [
            'message' => 'Estudiante actualizado parcialmente',
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
