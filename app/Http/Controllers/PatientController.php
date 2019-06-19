<?php

namespace App\Http\Controllers;

use App\Diseases;
use App\Questions;
use App\SessionAnswers;
use App\Sessions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function home()
    {
        return view('patient.home');
    }

    public function consultationView()
    {
        return view('patient.consultation');
    }

    public function getAllQuestions()
    {
        $questions = Questions::get();
        foreach ($questions as $question) {
            if($question->parent_id == "a:1:{i:0;i:0;}")
                $question->parent_id = null;
            else
                $question->parent_id = unserialize($question->parent_id);
        }

        return response()->json($questions, 200);
    }

    public function getAllDiseases()
    {
        $diseases = Diseases::get();

        return response()->json($diseases, 200);
    }

    public function addSessionAnswer(Request $request)
    {
        $userId = Auth::user()->id;

        $session = Sessions::create([
            "user_id" => $userId,
            "disease_id" => $request->disease_id
        ]);

        foreach ($request->answers as $answer) {
            SessionAnswers::create([
                "sessions_id" => $session->id,
                "question_id" => $answer['question_id'],
                "answer" => $answer['answer']
            ]);
        }

        return response()->json($request->all(), 200);
    }
}
