<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveyAnswersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $surveyId;

    public function __construct($id = 1)
    {
        $this->surveyId = $id;
    }
    public function collection()
    {
        $answers = DB::table('survey_answers')->join('survey_question_answers', 'survey_answers.id', 'survey_question_answers.survey_answer_id')->where('survey_answers.survey_id', $this->surveyId)->get([
            "survey_answers.id as id",
            "survey_question_answers.survey_question_id as id_question",
            "survey_answers.survey_id as id_survey",
            "survey_question_answers.answer as value",
        ]);
        $questions = DB::table('survey_questions')->join('surveys', 'survey_questions.survey_id', 'surveys.id')->where('surveys.id', $this->surveyId)->get(['survey_questions.id as id', 'question']);

        $resultsRaw = [];

        foreach ($answers as $a) {
            foreach ($questions as $q) {
                if ($a->id_question == $q->id) {
                    $resultsRaw[$a->id][] = [
                        $q->question => $a->value,
                    ];
                }
            }
        }

        $results = [];
        foreach ($resultsRaw as $id => $value) {
            $temp = [
                'id' => $id
            ];
            foreach ($value as $t) {
                $temp = array_merge($temp, $t);
            }
            $results[] =  $temp;
        }

        return collect($results);
    }

    public function headings(): array
    {

        $questions = DB::table('survey_questions')->join('surveys', 'survey_questions.survey_id', 'surveys.id')->where('surveys.id', $this->surveyId)->get(['question']);

        $header[0] = 'id';
        $question = [];
        foreach ($questions as $key => $value) {
            $question[$key] = $value->question;
        }
        $header = array_merge($header, $question);

        return $header;
    }
}
