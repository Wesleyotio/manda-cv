<?php

namespace App\Http\Controllers;

use App\Enums\EducationLevel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    //
    public function listEducationLevel()
    {
        $response = [
            'success' => true,
            'educationLevels' => EducationLevel::forSelect()
        ];

        return response()->json($response, 200);
    }

    public function sendCurriculumVitae(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:candidates',
            'phone' => 'nullable|string|digits_between:11,11',
            'job' => 'required|string|max:255',
            'education_level' => 'required|integer',
            'obs' => 'nullable|string|max:255' , 
            'doc_name_cv' => 'required|string',
            'ip_candidate' => 'required|string|max:15'
        ]);
        
        try {
            
            $response = [
                'success' => true,
                'message' => 'Currículo enviado com sucesso',
            ];
            return response()->json($response, 200);
        } catch (QueryException $qe) {
            $success = false;
            $message = $qe;

            $response = [
                'success' => $success,
                'message' => $message,
            ];
            return response()->json($response, 500);
        }
    }
}
