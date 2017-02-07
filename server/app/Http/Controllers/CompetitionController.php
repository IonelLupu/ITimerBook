<?php

namespace App\Http\Controllers;

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
                'answer4' => 'Marseille'
            ] ,

            [
                'body' => 'Care este capitala Angliei ?' ,
                'answer1' => 'Manchester' ,
                'answer2' => 'Londra' ,
                'answer3' => 'Liverpool' ,
                'answer4' => 'Bolton'
            ] ,

            [
                'body' => 'Care este capitala Spaniei ?' ,
                'answer1' => 'Madrid' ,
                'answer2' => 'Barcelona' ,
                'answer3' => 'Sevilla' ,
                'answer4' => 'Marbella'
            ]

      ] ;

        return $questions;
    }

    public function getCorrectAnswer(Request $request){

        $correctAnswer = $request->get("correct_answer") ;

        return $correctAnswer;
    }

    public function postAnswers(){

//        $answer = $request->get("answers") ;
//
//
//        $this->validate($request, [
//
//
//        ]);
//
//        var collectCorrectAnswers ;
//
//        for (var i = 1; i <= 4; i++){
//
//            if($answer[i]==$correctAnswer) {
//
//                collectCorrectAnswers == collectCorrectAnswers + 1;
//            }
//        }
//
//        return collectCorrectAnswers ;

    }
}
