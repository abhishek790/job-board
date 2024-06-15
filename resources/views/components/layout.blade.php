<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Job Board </title>

        @vite('resources/css/app.css')
    </head>
    <body >
        {{-- slots is adding the output of a slot special variable inside your component and it works for all blade components and what this slot variable does is that in your other normal blade files for every individual route you can use the layout component like that by adding x layout and then all the content that you pass in between the component tags will basically fill this slot variable--}}

        {{$slot}} {{-- outputs the content of a slot --}}
    </body>
</html>
