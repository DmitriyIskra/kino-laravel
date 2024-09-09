<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="css/client/normalize.css">
  <link rel="stylesheet" href="css/client/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <div class="admin__login">
    <a href="/login" title="login">Администраторская</a>
  </div>

  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>
  
  <nav class="page-nav">
    <a class="page-nav__day page-nav__day_today" href="#">
      <span class="page-nav__day-week">Пн</span><span class="page-nav__day-number">31</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Вт</span><span class="page-nav__day-number">1</span>
    </a>
    <a class="page-nav__day page-nav__day_chosen" href="#">
      <span class="page-nav__day-week">Ср</span><span class="page-nav__day-number">2</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Чт</span><span class="page-nav__day-number">3</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Пт</span><span class="page-nav__day-number">4</span>
    </a>
    <a class="page-nav__day page-nav__day_weekend" href="#">
      <span class="page-nav__day-week">Сб</span><span class="page-nav__day-number">5</span>
    </a>
    <a class="page-nav__day page-nav__day_next" href="#">
    </a>
  </nav>
  
  <main> 
    {{ dd($films[0]) }}
    @foreach ($films as $film)
      @if ($film->is_active)
        <section class="movie">

          <div class="movie__info">
            <div class="movie__poster">
              <img class="movie__poster-image" alt="{{ $film->title }} постер" src="{{ $film->poster }}">
            </div>
            <div class="movie__description">
              <h2 class="movie__title">{{ $film->title }}</h2>
              <p class="movie__synopsis">{{ $film->description }}</p>
              <p class="movie__data">
                <span class="movie__data-duration">{{ $film->duration }} минут</span>
                <span class="movie__data-origin">{{ $film->country }}</span>
              </p>
            </div>
          </div>

          <div class="movie-seances__hall">
            <h3 class="movie-seances__hall-title">Зал 1</h3>
            <ul class="movie-seances__list">
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">10:20</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">14:10</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">18:40</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">22:00</a></li>
            </ul>
          </div>

          <div class="movie-seances__hall">
            <h3 class="movie-seances__hall-title">Зал 2</h3>
            <ul class="movie-seances__list">
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">11:15</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">14:40</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">16:00</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">18:30</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">21:00</a></li>
              <li class="movie-seances__time-block"><a class="movie-seances__time" href="/hall">23:30</a></li>     
            </ul>
          </div> 

        </section>
      @endif  
    @endforeach
  </main>
  
</body>
</html>