<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Exam Result</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $attempt->category->name }} Exam</h5>
                <p class="card-text">Total Questions: {{ $attempt->total_questions }}</p>
                <p class="card-text">Correct Answers: {{ $attempt->correct_answers }}</p>
                <p class="card-text">Incorrect Answers: {{ $attempt->total_questions - $attempt->correct_answers }}</p>
                <p class="card-text">Score: {{ $attempt->score }} points</p>
            </div>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Back to Home</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
