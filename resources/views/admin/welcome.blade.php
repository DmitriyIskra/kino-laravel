<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="css/admin/normalize.css">
  <link rel="stylesheet" href="css/admin/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
  <script src="js/admin/accordeon.js" deffer></script>
  <script src="js/admin/app.js" type="module" deffer></script>
</head>

<body> 

  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Администраторская</span>
  </header>
  
  <main class="conf-steps main-admin">
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Управление залами</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Доступные залы:</p>
        <ul class="conf-step__list">
          @if (count($halls))
              @foreach ($halls as $item)
              <li>Зал {{ $item->id }}
                <a 
                  class="conf-step__button conf-step__button-trash conf-step__button-trash-hall"
                  href="/delete-hall/{{ $item->id }}"
                ></a>
              </li>
              @endforeach
          @else
              <li>Доступных залов нет.</li>
          @endif
        </ul>
        <a class="conf-step__button conf-step__button-accent conf-step__create-hall-button" href="/create_hall">Создать зал</a>
      </div>
    </section>
    
    <section class="configure-hall conf-step conf-step__configure-hall">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация залов</h2>
      </header>

      <div class="conf-step__wrapper">

        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          @if (count($halls))
              @foreach ($halls as $key => $item)
                <li data-id_hall="{{ $item->id }}">
                  <input 
                    type="radio" 
                    class="conf-step__radio" 
                    name="chairs-hall" 
                    value="Зал {{ $item->id }}" 
                    @if ($key === 0)
                        checked
                    @endif 
                  >
                  <span class="conf-step__selector">Зал {{ $item->id }}</span>
                </li>
              @endforeach
          @else
              <li>Доступных залов нет.</li>
          @endif
        </ul>

        <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
        <div class="conf-step__legend">
          <label class="conf-step__label">
            Рядов, шт
            <input type="text" class="conf-step__input conf-step__input-row" placeholder="@if(isset($halls[0])) {{ $halls[0]->row }} @endif" >
          </label>
          <span class="multiplier">x</span>
          <label class="conf-step__label">
            Мест в ряду, шт
            <input type="text" class="conf-step__input conf-step__input-place" placeholder="@if(isset($halls[0])) {{ $halls[0]->row }} @endif" >
          </label>
        </div>

        <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
        <div class="conf-step__legend">
          <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
          <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
          <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
          <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
        </div>  
        
        {{-- conf-step__chair_disabled - не доступно --}}
        {{-- conf-step__chair_standart - стандарт --}}
        {{-- conf-step__chair_vip - vip --}}
        <div class="conf-step__hall">
          <div class="conf-step__hall-wrapper">
            @if (count($halls))
                @for ($i = 0; $i < $halls[0]->row; $i++)
                  <div class="conf-step__row">
                    @for ($j = 0; $j < $halls[0]->place; $j++)
                      <span class="conf-step__chair conf-step__chair_standart"></span>
                    @endfor
                  </div>
                @endfor
            @endif
          </div>  
        </div>
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular configure-hall__reset">Отмена</button>
          <input class="conf-step__button conf-step__button-accent configure-hall__accent conf-step__button-accent_disabled" type="submit" value="Сохранить">
        </fieldset>                 
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          <li><input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 1"><span class="conf-step__selector">Зал 1</span></li>
          <li><input type="radio" class="conf-step__radio" name="prices-hall" value="Зал 2" checked><span class="conf-step__selector">Зал 2</span></li>
        </ul>
          
        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" ></label>
            за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
          </div>  
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0" value="350"></label>
            за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
          </div>  
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular">Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
          <button class="conf-step__button conf-step__button-accent">Добавить фильм</button>
        </p>
        <div class="conf-step__movies">
          <div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="img/admin/poster.png">
            <h3 class="conf-step__movie-title">Звёздные войны XXIII: Атака клонированных клонов</h3>
            <p class="conf-step__movie-duration">130 минут</p>
          </div>
          
          <div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="img/admin/poster.png">
            <h3 class="conf-step__movie-title">Миссия выполнима</h3>
            <p class="conf-step__movie-duration">120 минут</p>
          </div>
          
          <div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="img/admin/poster.png">
            <h3 class="conf-step__movie-title">Серая пантера</h3>
            <p class="conf-step__movie-duration">90 минут</p>
          </div>
          
          <div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="img/admin/poster.png">
            <h3 class="conf-step__movie-title">Движение вбок</h3>
            <p class="conf-step__movie-duration">95 минут</p>
          </div>   
          
          <div class="conf-step__movie">
            <img class="conf-step__movie-poster" alt="poster" src="img/admin/poster.png">
            <h3 class="conf-step__movie-title">Кот Да Винчи</h3>
            <p class="conf-step__movie-duration">100 минут</p>
          </div>            
        </div>
        
        <div class="conf-step__seances">
          <div class="conf-step__seances-hall">
            <h3 class="conf-step__seances-title">Зал 1</h3>
            <div class="conf-step__seances-timeline">
              <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 0;">
                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                <p class="conf-step__seances-movie-start">00:00</p>
              </div>
              <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                <p class="conf-step__seances-movie-start">12:00</p>
              </div>
              <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                <p class="conf-step__seances-movie-start">14:00</p>
              </div>              
            </div>
          </div>
          <div class="conf-step__seances-hall">
            <h3 class="conf-step__seances-title">Зал 2</h3>
            <div class="conf-step__seances-timeline">
              <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 595px;">
                <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                <p class="conf-step__seances-movie-start">19:50</p>
              </div>
              <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 660px;">
                <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                <p class="conf-step__seances-movie-start">22:00</p>
              </div>              
            </div>
          </div>
        </div>
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular">Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper text-center">
        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
        <button class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button>
      </div>
    </section>    
  </main>
</body>
</html>
