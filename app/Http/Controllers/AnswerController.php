<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResource;
use App\Http\Resources\SurveyResourceDashboard;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $answers = SurveyAnswer::query()->join('surveys', 'survey_answers.survey_id', 'surveys.id')->where('survey_id', $request->query('id'))->where('surveys.user_id', $user->id)->paginate($request->query('limit'));

        return AnswerResource::collection($answers);
    }

    public function getTotalAnswer()
    {
    }

    public function getAnswer()
    {
        $answers = DB::table('survey_answers')->join('survey_question_answers', 'survey_answers.id', 'survey_question_answers.survey_answer_id')->where('survey_answers.id', 3)->get([
            "survey_question_answers.survey_question_id as id",
            "survey_question_answers.answer as value",
        ]);

        $answerData = [];

        foreach ($answers as $answer) {
            $answerData[$answer->id] = $answer->value;
        }

        return [
            'answers' => $answerData,
        ];
    }
}
