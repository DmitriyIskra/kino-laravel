<div class="wrapper-modal modal__add-film">
    <form class="add-film-sess__form add-film__form"  name="add_film" enctype="multipart/form-data">
        @csrf
        <label class="add-film-sess__label">
            Название фильма
            <input class="add-film-sess__input" type="text" name="title" required>
        </label>
        <label class="add-film-sess__label">
            Продолжительность фильма
            <input class="add-film-sess__input" type="text" name="duration" required>
        </label>
        <label class="add-film-sess__label">
            Страна производитель
            <input class="add-film-sess__input" type="text" name="country" required>
        </label>
        <label class="add-film-sess__label">
            Описание фильма
            <textarea class="add-film-sess__textarea" type="text" name="description" required></textarea>
        </label>
        <label class="add-film-sess__label">
            Постер фильма
            <input class="add-film-sess__file" type="file" name="poster" accept="image/*" required>
        </label>

        <div class="add-film-sess__wr-buttons">
            <input class="conf-step__button conf-step__button-regular add-film__reset" type="reset" value="Отмена">
            <input class="conf-step__button conf-step__button-accent add-film-sess__submit" type="submit" value="Сохранить">
        </div>
    </form>
</div>