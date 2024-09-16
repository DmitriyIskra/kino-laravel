<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href={{ asset("css/client/normalize.css") }}>
  <link rel="stylesheet" href={{ asset("css/client/styles.css") }}>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
  <script src={{ asset("js/client/app.js") }} type="module" deffer></script>
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title"><a href="/">Идём<span>в</span>кино</a></h1>
  </header>

  <main>
    <section class="buying">
      <div class="buying__info">
        <div class="buying__info-description">
          <h2 class="buying__info-title">{{ $session->film_name }}</h2>
          <p class="buying__info-start">Начало сеанса: {{ $session->start_h }}:{{$session->start_m}}</p>
          <p class="buying__info-hall">Зал {{ $hall->number }}</p>          
        </div>
        <div class="buying__info-hint">
          <p>Тапните дважды,<br>чтобы увеличить</p>
        </div>
      </div>
      <div class="buying-scheme">
        <div class="buying-scheme__wrapper">
          @if ($hall->row && $hall->place)
            @foreach ($places as $key => $row)
              <div class="buying-scheme__row" data-row_num="{{ $key + 1 }}">
                  @foreach ($row as $place)
                    <span 
                      class="buying-scheme__chair buying-scheme__chair_{{$place->is_free ? $place->type : 'taken'}}"
                      data-place_id="{{$place->id}}"
                      data-price="{{$hall["price_"."$place->type"]}}"
                      data-film_id="{{ $session->film_id }}"
                      data-session_id="{{ $session->id }}"
                      data-hall_id="{{ $hall->id }}"
                      data-row_num="{{ $key + 1 }}"

                      data-default_type="{{ $place->type }}"
                    ></span>
                  @endforeach
              </div>
            @endforeach
          @endif
        </div>
        <div class="buying-scheme__legend">
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">{{ $hall->price_standart }}</span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">{{ $hall->price_vip }}</span>руб)</p>            
          </div>
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
          </div>
        </div>
      </div>
      <p class="not-choosed"></p>
      <button class="acceptin-button" data-date_of_booking="{{ $date_of_booking }}">Забронировать</button>
    </section>     
  </main>
  
</body>
</html>