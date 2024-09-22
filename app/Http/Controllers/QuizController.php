<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Attempt;
use Illuminate\Http\Request;
use Carbon\Carbon;
class QuizController extends Controller
{
    public function index()
    {
        $categories = Category::whereRaw('publish_at >= CURDATE()')
            ->withCount(['questions' => function ($query) {
                $query->whereHas('category', function ($subQuery) {
                    $subQuery->whereRaw('publish_at >= CURDATE()');
                });
            }])
            ->having('questions_count', '>', 0)
            ->get();
    
        return view('quiz.index', compact('categories'));
    }

    public function startExam(Category $category)
    {
        if ($category->publish_at < date('Y-m-d')) {
            return redirect()->route('quiz.index')->with('error', 'This exam is not available today.');
        }

        $questions = $category->questions()->inRandomOrder()->get();

        if ($questions->isEmpty()) {
            return redirect()->route('quiz.index')->with('error', 'No questions available for this exam.');
        }

        return view('quiz.exam', compact('category', 'questions'));
    }
    public function submitExam(Request $request)
    {
        $answers = $request->input('answers');
        $categoryId = $request->input('category_id');

        $correctAnswers = 0;
        $totalQuestions = count($answers);

        foreach ($answers as $questionId => $answer) {
            $question = Question::find($questionId);
            if ($question->correct_answer == $answer) {
                $correctAnswers++;
            }
        }

        $score = $correctAnswers * 10;
        $attempt = Attempt::create([
            'user_name' => 'Tahamid Khan', // Set the user name to "Tahamid Khan"
            'category_id' => $categoryId,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
        ]);

        return redirect()->route('quiz.index')->with('success', 'Exam submitted successfully!');
    }

    public function showResult($attempt)
    {
        $attempt = Attempt::findOrFail($attempt);
        return view('quiz.result', compact('attempt'));
    }
}
