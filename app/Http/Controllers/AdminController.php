<?php

namespace App\Http\Controllers;

use App\Diseases;
use App\DiseaseSolutions;
use App\Questions;
use App\Solutions;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\Console\Question\Question;

class AdminController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function home()
    {
        return view('admin.home');
    }

    public function diseaseView()
    {
        return view('admin.disease');
    }

    public function getDisease()
    {
        $diseases = Diseases::get();

        return response()->json($diseases, 200);
    }

    public function addDisease(Request $request)
    {
        Diseases::create([
            "name" => $request->name
        ]);

        return response()->json($request->all(), 200);
    }

    public function editDisease(Request $request)
    {
        $disense = Diseases::where("id", $request->id)->first();

        $disense->update([
            "name" => $request->name
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteDisease(Request $request)
    {
        $disease = Diseases::where("id", $request->id)->first();
        $disease->delete();

        return response()->json($request->all(), 200);
    }

    public function getDiseaseById($id)
    {
        $disease = Diseases::where("id", $id)->first();

        return response()->json($disease, 200);
    }

    public function solutionView()
    {
        return view('admin.solution');
    }

    public function getSolutions()
    {
        $solutions = Solutions::get();

        return response()->json($solutions, 200);
    }

    public function addSolution(Request $request)
    {
        Solutions::create([
            "context" => $request->context
        ]);

        return response()->json($request->all(), 200);
    }

    public function editSolution(Request $request)
    {
        $solution = Solutions::where("id", $request->id)->first();

        $solution->update([
            "context" => $request->context
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteSolution(Request $request)
    {
        $solution = Solutions::where("id", $request->id)->first();
        $solution->delete();

        return response()->json($request->all(), 200);
    }

    public function getSolutionById($id)
    {
        $solution = Solutions::where("id", $id)->first();

        return response()->json($solution, 200);
    }

    public function questionView()
    {
        return view('admin.question');
    }

    public function getQuestions()
    {
        $questions = Questions::orderBy('disease_id', 'DESC')->get();
        foreach ($questions as $question) {
            $question->parent_id = unserialize($question->parent_id);
        }

        return response()->json($questions, 200);
    }

    public function getQuestionById($id)
    {
        $question = Questions::where("id", $id)->first();
        $question->parent_id = unserialize($question->parent_id);

        return response()->json($question, 200);
    }

    public function addQuestion(Request $request)
    {
        $parent_id = $request->questionId;
        $parent_id = serialize($parent_id);

        Questions::create([
            "disease_id" => $request->diseaseId,
            "parent_id" => $parent_id,
            "question" => $request->question
        ]);

        return response()->json($request->all(), 200);
    }

    public function editQuestion(Request $request)
    {
        $parent_id = $request->questionId;
        $parent_id = serialize($parent_id);

        $question = Questions::where("id", $request->id)->first();
        $question->update([
            "disease_id" => $request->diseaseId,
            "parent_id" => $parent_id,
            "question" => $request->question
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteQuestion(Request $request)
    {
        $question = Questions::where("id", $request->id)->first();
        $question->delete();

        return response()->json($request->all(), 200);
    }

    public function getQuestionByDiseaseId($disease_id)
    {
        $questions = Questions::where("disease_id", $disease_id)->get();
        foreach ($questions as $question) {
            $question->parent_id = unserialize($question->parent_id);
        }

        return response()->json($questions, 200);
    }

    public function patientListView()
    {
        return view('admin.list-user');
    }

    public function getListPatients()
    {
        $patients = User::where("role", "patient")->get();

        return response()->json($patients, 200);
    }

    public function diseaseSolutionView()
    {
        return view('admin.disease-solution');
    }

    public function getDiseaseSolutions()
    {
        $diseaseSolutions = DiseaseSolutions::orderBy('disease_id', 'DESC')->with(["disease", "solution"])->get();

        return response()->json($diseaseSolutions, 200);
    }

    public function addDiseaseSolution(Request $request)
    {
        DiseaseSolutions::create([
            "solution_id" => $request->solutionId,
            "disease_id" => $request->diseaseId
        ]);

        return response()->json($request->all(), 200);
    }

    public function editDiseaseSolution(Request $request)
    {
        $diseaseSolution = DiseaseSolutions::where("id", $request->id)->first();
        $diseaseSolution->update([
            "solution_id" => $request->solutionId,
            "disease_id" => $request->diseaseId
        ]);

        return response()->json($request->all(), 200);
    }

    public function deleteDiseaseSolution(Request $request)
    {
        $diseaseSolution = DiseaseSolutions::where("id", $request->id)->first();
        $diseaseSolution->delete();

        return response()->json($request->all(), 200);
    }

    public function getDiseaseSolutionById($id)
    {
        $diseaseSolution = DiseaseSolutions::where("id", $id)->first();

        return response()->json($diseaseSolution, 200);
    }
}
