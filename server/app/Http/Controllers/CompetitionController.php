<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Competition;
use App\Models\Participant;
use App\Models\Question;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CompetitionController extends Controller
{

	public function getCompetition()
	{

		$competition = Competition::with('participants')->current()->first();

		return $competition;
	}

	public function getQuestions()
	{
		$questions = [

			[
				'competition_id' => 1,
				'body'           => 'Care este capitala Frantei ?',
				'answer1'        => 'Nice',
				'answer2'        => 'Lyon',
				'answer3'        => 'Paris',
				'answer4'        => 'Marseille',
				'correct_answer' => 3
			],

			[
				'competition_id' => 1,
				'body'           => 'Care este capitala Angliei ?',
				'answer1'        => 'Manchester',
				'answer2'        => 'Londra',
				'answer3'        => 'Liverpool',
				'answer4'        => 'Bolton',
				'correct_answer' => 2
			],

			[
				'competition_id' => 1,
				'body'           => 'Care este capitala Spaniei ?',
				'answer1'        => 'Madrid',
				'answer2'        => 'Barcelona',
				'answer3'        => 'Sevilla',
				'answer4'        => 'Marbella',
				'correct_answer' => 1
			],

			[
				'competition_id' => 1,
				'body'           => 'Care este capitala Germaniei ?',
				'answer1'        => 'Koln',
				'answer2'        => 'Munchen',
				'answer3'        => 'Dortmund',
				'answer4'        => 'Berlin',
				'correct_answer' => 4
			],

			[
				'competition_id' => 1,
				'body'           => 'Care este capitala Italiei ?',
				'answer1'        => 'Florence',
				'answer2'        => 'Milan',
				'answer3'        => 'Bologna',
				'answer4'        => 'Roma',
				'correct_answer' => 4
			]

		];

		$competition = Competition::current()->first();

		foreach ($questions as $question){
			$competition->questions()->save(Question::create($question));
		}

//		return $questions;
		return $competition->questions()->get(["answer1", "answer2", "answer3", "answer4", "body"]);
	}

	public function postAnswers(Request $request)
	{

		$answers = $request->get("answers");


		$competition = Competition::current()->first();
		$questions   = $competition->questions;

		$collectCorrectAnswers = 0;
		foreach ($questions as $index => $question) {
			if ($answers[ $index ] == $question['correct_answer'])
				$collectCorrectAnswers++;
		}


		$this->user->participant->ended_quiz_at        = Carbon::now();
		$this->user->participant->correct_quiz_answers = $collectCorrectAnswers;
		$this->user->participant->save();

		return $collectCorrectAnswers;
	}

	public function postParticipate()
	{

		$competition = Competition::with('participants')->current()->first();

		if ($competition->min_points > $this->user->points)
			throw new \Exception("Ai nevoie de cel putin ".$competition->min_points." pentru a intra in concurs");

		foreach ($competition->participants as $participant) {
			if ($participant->user_id == $this->user->id)
				throw new \Exception("Esti deja inregistrat in concurs");
		}

		// add to participants list
		$competition->participants()->save(
			new Participant([
				"user_id" => $this->user->id
			])
		);

		// add book to current books list
		$this->user->books()->save(
			new Book([
				"title"    => $competition->bookToRead_name,
				"pages"    => $competition->bookToRead_pages,
				"bookmark" => 0,
				"author"   => $competition->bookToRead_author,
				"finished" => false,
				"added_at" => Carbon::now()
			])
		);

		return "true";
	}

	public function postTakeQuiz()
	{
		if ($this->user->participant->took_quiz)
			throw new \Exception("Poti raspunde doar o singura data la intrebarile concursului!");

		$this->user->participant->started_quiz_at = Carbon::now();
		$this->user->participant->took_quiz       = true;
		$this->user->participant->save();
	}

}

