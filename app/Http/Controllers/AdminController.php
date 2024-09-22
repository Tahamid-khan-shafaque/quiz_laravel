<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use App\Models\Attempt;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function index()
    {
        $categories = Category::count();
        $questions = Question::count();
        $attempts = Attempt::count();

        return view('admin.dashboard', compact('categories', 'questions', 'attempts'));
    }


    public function questions()
    {
        $questions = Question::with('category')->get();
        return view('admin.questions', compact('questions'));
    }

    public function addQuestion()
    {
        $categories = Category::all();
        return view('admin.add_question', compact('categories'));
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        Question::create($request->all());

        // return redirect()->route('admin.questions')->with('success', 'Question added successfully');
        return redirect()->route('admin.add_question')->with('success', 'Question added successfully');

    }
    

    public function results()
    {
        $attempts = Attempt::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.results', compact('attempts'));
    }
    public function categories()
    {
        $categories = Category::withCount('questions')->get();
        return view('admin.categories', compact('categories'));
    }

    public function publishCategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'publish_at' => 'required|date_format:Y-m-d'
        ]);

        $category = Category::findOrFail($request->category_id);
        $category->publish_at = Carbon::parse($request->publish_at)->startOfDay();
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category scheduled for publication successfully');
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::findOrFail($request->category_id);
        $category->questions()->delete();
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category and all related questions have been deleted.');
    }

    public function addCategory()
    {
        return view('admin.add_category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'duration' => 'required|integer|min:1',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories')->with('success', 'Category added successfully');
    }
}
