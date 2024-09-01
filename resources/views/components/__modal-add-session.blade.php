<div class="wrapper-modal modal__session">
    <form class="films-session__form session__add-form" name="add_session" enctype="multipart/form-data">      
        <label class="film-session__label">
            Доступные фильмы
            @if (count($halls))
                <select name="film">
 
                </select>
            @else
                <br /> Нет доступных залов для показа фильма
            @endif
             
        </label>
        <div class="session__start-film">
            <p>Начало сеанса</p>
            <div class="session__wr-inputs">
                <label class="film-session__label session__label">
                    <input class="film-session__input session__input" type="text" name="hour" required> часов
                </label>
                <label class="film-session__label session__label">
                    <input class="film-session__input session__input" type="text" name="min" required> минут
                </label>
            </div>
        </div>

        <div class="add-film-sess__wr-buttons">
            <input class="conf-step__button conf-step__button-regular session__add-reset" type="reset" value="Отмена">
            <input class="conf-step__button conf-step__button-accent add-film-sess__submit" type="submit" value="Сохранить">
        </div>
    </form>
</div>