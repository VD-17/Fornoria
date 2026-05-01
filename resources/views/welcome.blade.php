<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <section class="hero">
            <div class="slogan">
                <div class="hero-bg">
                    <img src="images/restaurant/hero.jpeg" width="1880" height="950" class="" alt="">
                </div>
                <p>DELIGHTFUL EXPERIENCE</p>
                <h1>For the love of delicious food</h1>
                <p>Come with family & feel the joy of mouthwatering food</p>
            </div>

            <div class="action-btns">
                <a href="#">View Our Menu</a>
                <a href="{{ route('order') }}">ORDER</a>
            </div>
        </section>
    </body>
</html>
