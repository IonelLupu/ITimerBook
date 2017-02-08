<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Question;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function getQuestions()
    {
        $questions = [

            [
                'body' => 'Care este capitala Frantei ?' ,
                'answer1' => 'Nice' ,
                'answer2' => 'Lyon' ,
                'answer3' => 'Paris' ,
                'answer4' => 'Marseille',
                'correct_answer' => 3
            ] ,

            [
                'body' => 'Care este capitala Angliei ?' ,
                'answer1' => 'Manchester' ,
                'answer2' => 'Londra' ,
                'answer3' => 'Liverpool' ,
                'answer4' => 'Bolton',
                'correct_answer' => 2
            ] ,

            [
                'body' => 'Care este capitala Spaniei ?' ,
                'answer1' => 'Madrid' ,
                'answer2' => 'Barcelona' ,
                'answer3' => 'Sevilla' ,
                'answer4' => 'Marbella',
                'correct_answer' => 1
            ] ,

            [
                'body' => 'Care este capitala Germaniei ?' ,
                'answer1' => 'Koln' ,
                'answer2' => 'Munchen' ,
                'answer3' => 'Dortmund' ,
                'answer4' => 'Berlin',
                'correct_answer' => 4
            ] ,

            [
                'body' => 'Care este capitala Italiei ?' ,
                'answer1' => 'Florence' ,
                'answer2' => 'Milan' ,
                'answer3' => 'Bologna' ,
                'answer4' => 'Roma',
                'correct_answer' => 4
            ]

      ] ;

        return $questions;
    }

    public function postAnswers(Request $request){

        $answers = $request->get("answers") ;


        $collectCorrectAnswers = 0 ;

        $questions = $this->getQuestions();

        foreach ($questions  as $index => $question){
            if( $answers[$index] == $question['correct_answer'] )
                $collectCorrectAnswers++;
        }


        return $collectCorrectAnswers ;

    }

}

