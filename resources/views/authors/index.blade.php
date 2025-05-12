<!DOCTYPE html>
<html>
<head>
    <title>Authors</title>
</head>
<body>
    <h1>Authors</h1>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Author</th>
        </tr>
        @foreach($authors as $author)
        <tr>
            <td>{{ $author->id }}</td>
            <td>{{ $author->name }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
