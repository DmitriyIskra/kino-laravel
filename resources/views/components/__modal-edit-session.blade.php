<div class="wrapper-modal modal__edit-session">
    <form class="films-session__form session__form" name="add_session" enctype="multipart/form-data">      
        <p class="session-edit__film-name"></p>
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
            <input class="conf-step__button conf-step__button-regular session-edit__reset" type="reset" value="Отмена">
            <input class="conf-step__button conf-step__button-accent add-film-sess__submit" type="submit" value="Сохранить">
        </div>
    </form>
</div>