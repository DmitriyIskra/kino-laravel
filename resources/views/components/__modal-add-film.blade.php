<div class="wrapper-modal">
    <form class="add-film__form" action="/save_film" method="POST"  name="add_film" enctype="multipart/form-data">
        @csrf
        <label class="add-film__label">
            Название фильма
            <input class="add-film__input" type="text" name="title" required>
        </label>
        <label class="add-film__label">
            Продолжительность фильма
            <input class="add-film__input" type="text" name="duration" required>
        </label>
        <label class="add-film__label">
            Страна производитель
            <input class="add-film__input" type="text" name="country" required>
        </label>
        <label class="add-film__label">
            Описание фильма
            <textarea class="add-film__textarea" type="text" name="description" required></textarea>
        </label>
        <label class="add-film__label">
            Постер фильма
            <input class="add-film__file" type="file" name="poster" accept="image/*" required>
        </label>

        <div class="add-film__wr-buttons">
            <input class="conf-step__button conf-step__button-regular add-film__reset" type="reset" value="Отмена">
            <input class="conf-step__button conf-step__button-accent add-film__submit" type="submit" value="Сохранить">
        </div>
    </form>
</div>