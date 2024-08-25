<div class="wrapper-modal modal__add-session">
    <form class="add-film-sess__form add-sess__form" name="add_session" enctype="multipart/form-data">

        <label class="add-film-sess__label add-sess__label">
            Доступные фильмы
            @if (count($halls))
                <select name="film">
                    @foreach ($films as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                </select>
            @else
                <br /> Нет доступных залов для показа фильма
            @endif
            
        </label>
        <div class="add-sess__start-film">
            <p>Начало фильма</p>
            <div class="add-sess__wr-inputs">
                <label class="add-sess__label">
                    <input class="add-film-sess__input add-sess__input" type="text" name="hour" required> часов
                </label>
                <label class="add-sess__label">
                    <input class="add-film-sess__input add-sess__input" type="text" name="min" required> минут
                </label>
            </div>
        </div>

        <div class="add-film-sess__wr-buttons">
            <input class="conf-step__button conf-step__button-regular add-sess__reset" type="reset" value="Отмена">
            <input class="conf-step__button conf-step__button-accent add-film-sess__submit" type="submit" value="Сохранить">
        </div>
    </form>
</div>