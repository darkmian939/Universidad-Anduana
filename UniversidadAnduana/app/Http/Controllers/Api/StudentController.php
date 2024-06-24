<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() 
    { 
        $students = Student::all();

        if ($students->isEmpty()) {
            $data = [
                'message' => 'No hay estudiantes',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        return response()->json($students, 200);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nombre' => 'required|max:255',
        'apellido' => 'required|max:255',
        'career_id' => 'required|exists:careers,id', // Valida que career_id exista en la tabla careers
        'email' => 'required|email|unique:students',
        'password' => 'required|max:15',
    ]);

    if ($validator->fails()) {
        $data = [
            'message' => 'Error en validación de los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ];
        return response()->json($data, 400);
    }

    // Encriptar la contraseña
    $passwordHashed = Hash::make($request->password);

    $student = Student::create([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'career_id' => $request->career_id,
        'email' => $request->email,
        'password' => $passwordHashed,
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

        if(!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'carrera_id' => 'required|exists:carreras,id',
            'email' => 'required|email|unique:students,email,'.$id,
            'password' => 'required|max:15',
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
        $student->carrera_id = $request->carrera_id;
        $student->email = $request->email;
        $student->password = Hash::make($request->password); // Encriptar la contraseña

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

        if(!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'max:255',
            'apellido' => 'max:255',
            'carrera_id' => 'exists:carreras,id',
            'email' => 'email|unique:students,email,'.$id,
            'password' => 'max:15',
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

        if ($request->has('carrera_id')) {
            $student->carrera_id = $request->carrera_id;
        }

        if ($request->has('email')) {
            $student->email = $request->email;
        }

        if ($request->has('password')) {
            $student->password = Hash::make($request->password); // Encriptar la contraseña
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