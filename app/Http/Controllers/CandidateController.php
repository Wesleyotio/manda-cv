<?php

namespace App\Http\Controllers;

use App\Enums\EducationLevel;
use App\Mail\SendCandidate;
use Illuminate\Support\Facades\Mail;
use App\Models\Candidate;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'phone' => 'nullable|string|digits_between:10,12',
            'job' => 'required|string|max:255',
            'education_level' => 'required|integer',
            'obs' => 'nullable|string|max:255' , 
            'ip_candidate' => 'required|string|max:15'
        ]);
        
        try {
            
            if ($request->hasFile('doc_name_cv')) {

                $doc_cv = $request->file('doc_name_cv');
                if ($doc_cv->isValid() && $this->isValidMimeType($doc_cv->getMimeType())) {

                    $path = Storage::putFile('docs', $doc_cv);
                    $candidate = Candidate::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'job' => $request->job,
                        'education_level' => $request->education_level,
                        'obs' => $request->obs, 
                        'doc_name_cv' => $path,
                        'ip_candidate' => $request->ip_candidate
                    ]);
        
                    $response = [
                        'success' => true,
                        'message' => 'Currículo enviado com sucesso',
                    ];
                    $candidateResponse = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'job' => $request->job,
                        'education_level' => EducationLevel::label($request->education_level),
                        'obs' => $request->obs, 
                    ];
                    Mail::to($candidate->email)->send(new SendCandidate( $candidateResponse));

                    return response()->json($response, 200);
                }
            }

            $response = [
                'success' => false,
                'message' => "Falha ao processar o arquivo!",
            ];
            return response()->json($response, 400);
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

    private function isValidMimeType($mimeType): bool
    {
        switch ($mimeType) {
            case 'application/pdf':
                return true;
                break;
            case 'application/msword':
                return true;
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return true;
                break;
            default:
                return false;
                break;
        }
    }
}
