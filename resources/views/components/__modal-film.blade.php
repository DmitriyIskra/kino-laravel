
{{-- добавление или обновление фильма --}}
<div class="wrapper-modal modal__film">
    <form class="film-session__form film__form"  name="add_film" enctype="multipart/form-data">
        @csrf
        <label class="film-session__label">
            Название фильма
            <input class="film-session__input" type="text" name="title" required>
        </label>
        <label class="film-session__label">
            Продолжительность фильма
            <input class="film-session__input" type="text" name="duration" required>
        </label>
        <label class="film-session__label">
            Страна производитель
            <input class="film-session__input" type="text" name="country" required>
        </label>
        <label class="film-session__label">
            Описание фильма
            <textarea class="film__textarea" type="text" name="description" required></textarea>
        </label>
        <label class="film-session__label">
            Постер фильма
            <input class="film-sess__file" type="file" name="poster" accept="image/*" required>
        </label>

        <div class="film-sess__wr-buttons">
            <input class="conf-step__button conf-step__button-regular film-session__reset" type="reset" value="Отмена">
            <input class="conf-step__button conf-step__button-accent film-sess__submit" type="submit" value="Сохранить">
        </div>
    </form>
</div>