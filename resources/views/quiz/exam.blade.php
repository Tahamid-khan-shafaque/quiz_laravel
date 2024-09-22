<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">{{ $category->name }} Exam</h1>
        <form action="{{ route('quiz.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            @foreach($questions as $index => $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Question {{ $index + 1 }}</h5>
                        <p class="card-text">{{ $question->question }}</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer_{{ $question->id }}_a" value="a">
                            <label class="form-check-label" for="answer_{{ $question->id }}_a">{{ $question->option_a }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer_{{ $question->id }}_b" value="b">
                            <label class="form-check-label" for="answer_{{ $question->id }}_b">{{ $question->option_b }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer_{{ $question->id }}_c" value="c">
                            <label class="form-check-label" for="answer_{{ $question->id }}_c">{{ $question->option_c }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer_{{ $question->id }}_d" value="d">
                            <label class="form-check-label" for="answer_{{ $question->id }}_d">{{ $question->option_d }}</label>
                        </div>
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Submit Exam</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
