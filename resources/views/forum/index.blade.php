<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Top Quotes</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
        crossorigin="anonymous">
    <style>
        .wrapper {
            margin: 1em auto;
            width: 95%;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <h1>Forum</h1>
    @foreach ($topics as $topic)
            <h2>{{ $topic->title }}</h2>
            <p>Creator: {{ $topic->user->name }}</p>
            <div>{{ $topic->body }}</div>
        <br>
        <div>Comments: </div>
        @foreach ($topic->comments as $comment)
            <div>Commentor: {{ $comment->user->name }}</div>
            <div> - {{ $comment->body }}</div>
        @endforeach
            <br>
    @endforeach
</div>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous">
</script>
</body>
</html>
