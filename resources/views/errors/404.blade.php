<!DOCTYPE html>
<html lang="en">
@extends('layouts.client')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - Custom</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    <h1>404 Error Page</h1>
    <section class="error-container">
        <span class="four"><span class="screen-reader-text">4</span></span>
        <span class="zero"><span class="screen-reader-text">0</span></span>
        <span class="four"><span class="screen-reader-text">4</span></span>
    </section>

    <div class="link-container">
    <a href="/" class="more-link">
        Quay về trang chủ
    </a>
</div>

</body>

</html>