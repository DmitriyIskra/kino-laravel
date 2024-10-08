<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href={{ asset("css/client/normalize.css") }}>
  <link rel="stylesheet" href={{ asset("css/client/styles.css") }}>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
  <script src={{ asset("js/client/app.js") }} type="module" deffer></script>
</head>

<body>
  <div class="admin__login">
    <a href={{ Auth::check() ? '/admin' : '/login' }} title="login">Администраторская</a>
  </div>

  <header class="page-header">
    <h1 class="page-header__title"><a href="/">Идём<span>в</span>кино</a></h1>
  </header>
  
  <nav class="page-nav">

    @php $days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] @endphp

    <a class="page-nav__day page-nav__day_num page-nav__day_today page-nav__day_chosen" href="#">
      <span class="page-nav__day-week">@php echo $days[date('N') - 1] @endphp</span><span class="page-nav__day-number">{{ date('j') }}</span>
    </a>
    <a class="page-nav__day page-nav__day_num" href="#">
      <span class="page-nav__day-week">@php echo $days[date('N', strtotime("+1 day")) - 1] @endphp</span><span class="page-nav__day-number">{{ date('j', strtotime("+1 day")) }}</span>
    </a>
    <a class="page-nav__day page-nav__day_num" href="#">
      <span class="page-nav__day-week">@php echo $days[date('N', strtotime("+2 day")) - 1] @endphp</span><span class="page-nav__day-number">{{ date('j', strtotime("+2 day")) }}</span>
    </a>
    <a class="page-nav__day page-nav__day_num" href="#">
      <span class="page-nav__day-week">@php echo $days[date('N', strtotime("+3 day")) - 1] @endphp</span><span class="page-nav__day-number">{{ date('j', strtotime("+3 day")) }}</span>
    </a>
    <a class="page-nav__day page-nav__day_num" href="#">
      <span class="page-nav__day-week">@php echo $days[date('N', strtotime("+4 day")) - 1] @endphp</span><span class="page-nav__day-number">{{ date('j', strtotime("+4 day")) }}</span>
    </a>
    <a class="page-nav__day page-nav__day_num page-nav__day_weekend" href="#">
      <span class="page-nav__day-week">@php echo $days[date('N', strtotime("+5 day")) - 1] @endphp</span><span class="page-nav__day-number">{{ date('j', strtotime("+5 day")) }}</span>
    </a>
    <a class="page-nav__day page-nav__day_next" href="#">
    </a>

  </nav>
  
  <main> 
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
          {{-- {{ dd($films) }} --}}
          @foreach ($film->sessions as $key => $items)
              @if (count($items))
                <div class="movie-seances__hall">
                  <h3 class="movie-seances__hall-title">Зал {{ $key }}</h3>
                  <ul class="movie-seances__list">
                    @foreach ($items as $item)
                      <li class="movie-seances__time-block">
                        <a class="movie-seances__time" href="/hall/{{ $item->id }}/{{ $item->hall_id }}">{{ $item->start_h }}:{{$item->start_m}}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endif
          @endforeach
        </section>
      @endif  
    @endforeach
  </main>
  
</body>
</html>