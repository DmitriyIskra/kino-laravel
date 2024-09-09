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
  <link rel="stylesheet" href="css/modals/styles.css">
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
              <li>Зал {{ $item->number }}
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
        <ul class="conf-step__selectors-box conf-step__selectors-hall">
          @if (count($halls))
              @foreach ($halls as $key => $item)
                <li data-id_hall="{{ $item->id }}">
                  <input 
                    type="radio" 
                    class="conf-step__radio" 
                    name="chairs-hall" 
                    value="Зал {{ $item->number }}" 
                    data-id_hall="{{ $item->id }}"
                    @if ($key === 0)
                        checked
                    @endif 
                  >
                  <span class="conf-step__selector">Зал {{ $item->number }}</span>
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
            <input 
              type="text" 
              class="conf-step__input conf-step__input-row" 
              placeholder="0" 
              @if(isset($halls[0])) value="{{ $halls[0]->row ?? '' }}" @endif 
              @if (!isset($halls[0])) disabled @endif
            >
          </label>
          <span class="multiplier">x</span>
          <label class="conf-step__label">
            Мест в ряду, шт
            <input 
              type="text" 
              class="conf-step__input conf-step__input-place" 
              placeholder="0" 
              @if(isset($halls[0])) value="{{ $halls[0]->place ?? '' }}" @endif 
              @if (!isset($halls[0])) disabled @endif
            >
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
            @if (isset($places) && count($places))
              @foreach ($places as $item)
                <div class="conf-step__row">
                  @foreach ($item as $val)
                    <span 
                      class="conf-step__chair conf-step__chair_{{ $val['type'] }}" 
                      data-chair_num="{{ $val['chair_num'] }}" 
                      data-place_type="{{ $val['type'] }}"
                    ></span>
                  @endforeach
                </div>
              @endforeach
            @endif
          </div>  
        </div>
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular configure-hall__reset">Отмена</button>
          <input class="conf-step__button conf-step__button-accent configure-hall__accent conf-step__button-accent_disabled" type="submit" value="Сохранить">
        </fieldset>                 
      </div>
    </section>
    
    <section class="configure-price conf-step conf-step__configure-price">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box conf-step__selectors-price">
          @if (count($halls))
              @foreach ($halls as $key => $item)
                <li data-id_hall="{{ $item->id }}">
                  <input 
                    type="radio" 
                    class="conf-step__radio" 
                    name="prices-hall" 
                    value="Зал {{ $item->number }}" 
                    data-id_hall="{{ $item->id }}"
                    @if ($key === 0)
                        checked
                    @endif 
                  >
                  <span class="conf-step__selector">Зал {{ $item->number }}</span>
                </li>
              @endforeach
          @else
              <li>Доступных залов нет.</li>
          @endif
        </ul>
          
        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей
              <input 
                type="text" 
                class="conf-step__input conf-step__input-standart" 
                placeholder="0"
                @if(isset($halls[0])) value="{{ $halls[0]->price_standart ?? '' }}" @endif 
                @if (!isset($halls[0])) disabled @endif 
              >
            </label>
            за 
            <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
          </div>  
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей
              <input 
                type="text" 
                class="conf-step__input conf-step__input-vip" 
                placeholder="0"
                @if(isset($halls[0])) value="{{ $halls[0]->price_vip ?? '' }}" @endif 
                @if (!isset($halls[0])) disabled @endif 
              >
            </label>
            за 
            <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
          </div>  
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular configure-price__reset">Отмена</button>
          <input class="conf-step__button conf-step__button-accent configure-price__accent conf-step__button-accent_disabled" type="submit" value="Сохранить" >
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step conf-step__session-grid">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
      </header> 
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
          <button class="conf-step__button conf-step__button-accent conf-step__add-film">Добавить фильм</button>
        </p>
        <div class="conf-step__movies">
          @if ($films)
              @foreach ($films as $item)

                  <div class="conf-step__movie" data-id_movie="{{ $item->id }}">
                    <img class="conf-step__movie-poster" alt="poster" src="{{ $item->poster }}">
                    <h3 class="conf-step__movie-title">{{ $item->title }}</h3>
                    <p class="conf-step__movie-duration">{{ $item->duration }} минут</p>
                  </div>

              @endforeach
          @endif         
        </div>
        
        <div class="conf-step__seances">

          @if (count($halls))
            @foreach ($halls as $item)
                <div class="conf-step__seances-hall">
                  <h3 class="conf-step__seances-title">Зал {{$item->number}}</h3>
                  <div class="conf-step__seances-timeline" data-id_hall="{{ $item->id }}">

                  </div>
                </div>
            @endforeach
          @else
            <P>Ни один зал не создан</P>
          @endif
        </div>
        
        {{-- <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular">Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent conf-step__seances-submit">
        </fieldset>   --}}
      </div>

      @include('../components/__modal-film')
      @include('../components/__modal-edit-film')
      @include('../components/__modal-add-session')
      @include('../components/__modal-edit-session')
    </section>
    
    <section class="conf-step conf-step__activate-sales">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper text-center">
        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
        <p class="conf-step__paragraph conf-step__activation-result"></p>
        <button class="conf-step__button conf-step__button-accent conf-step__button-activate-sales">Открыть продажу билетов</button>
      </div>
    </section>   
  </main>
</body>
</html>
