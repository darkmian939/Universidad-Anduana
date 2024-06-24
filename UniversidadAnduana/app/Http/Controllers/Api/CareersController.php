<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Careers;
use Illuminate\Support\Facades\Validator;

class CareersController extends Controller
{
    public function index()
    {
        $careers = Careers::all();

        if ($careers->isEmpty()) {
            $data = [
                'message' => 'No hay carreras',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        return response()->json($careers, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:careers',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $career = Careers::create([
            'name' => $request->name,
        ]);

        if (!$career) {
            $data = [
                'message' => 'Error al crear la carrera',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'career' => $career,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $career = Careers::find($id);

        if (!$career) {
            $data = [
                'message' => 'Carrera no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'career' => $career,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $career = Careers::find($id);

        if (!$career) {
            $data = [
                'message' => 'Carrera no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:careers,name,' . $id,
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $career->name = $request->name;
        $career->save();

        $data = [
            'message' => 'Carrera actualizada',
            'career' => $career,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $career = Careers::find($id);

        if (!$career) {
            $data = [
                'message' => 'Carrera no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $career->delete();

        $data = [
            'message' => 'Carrera eliminada correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
