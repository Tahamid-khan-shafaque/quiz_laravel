<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Exam Results</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Category</th>
                    <th>Score</th>
                    <th>Total Questions</th>
                    <th>Correct Answers</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attempts as $attempt)
                    <tr>
                        <td>{{ $attempt->id }}</td>
                        <td>{{ $attempt->user_name }}</td>
                        <td>{{ $attempt->category->name }}</td>
                        <td>{{ $attempt->score }}</td>
                        <td>{{ $attempt->total_questions }}</td>
                        <td>{{ $attempt->correct_answers }}</td>
                        <td>{{ $attempt->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
