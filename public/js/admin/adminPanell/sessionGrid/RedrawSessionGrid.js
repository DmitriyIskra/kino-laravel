export default class RedrawSessionGrid {
    constructor(section) {
        this.section = section;

        this.wrapperMovies = this.section.querySelector('.conf-step__movies');

        this.filmModal = this.section.querySelector('.modal__add-film');
        this.filmEditModal = this.section.querySelector('.modal__edit-film');
        this.addSessionModal = this.section.querySelector('.modal__session');
        this.editSessionModal = this.section.querySelector('.modal__edit-session');
    }

    showModalFilm() { // открыть поп-ап добавить фильм
        this.filmModal.classList.add('wrapper-modal_active');
    }

    hideModalFilm() { // закрыть поп-ап добавить фильм
        this.filmModal.classList.remove('wrapper-modal_active');
    }

    showModalEditFilm(data) {
        this.filmEditModal.classList.add('wrapper-modal_active');
        const form = this.filmEditModal.querySelector('form');

        form.dataset.film_id = data.id;
        form.title.value = data.title;
        form.duration.value = data.duration;
        form.country.value = data.country;
        form.country.value = data.country;
        form.description.value = data.description;
    }

    hideModalEditFilm() { // закрыть поп-ап добавить фильм
        this.filmEditModal.classList.remove('wrapper-modal_active');
        const form = this.filmEditModal.querySelector('form');

        if(form.dataset?.film_id) {
            form.dataset.film_id = '';
        };
    }

    

    renderFilm(data) {
        const film = this.patternFilm(data);

        this.wrapperMovies.append(film);
    }

    updateFilm(data) { // обновление отображения фильма на странице
        const film = this.section.querySelector(`.conf-step__movie[data-id_movie="${data.id}"]`);

        film.children[0].src = data.poster;
        film.children[1].textContent = data.title;
        film.children[2].textContent = data.duration + ' ' + 'минут';

        // обновляем причасные к фильму сеансы
        this.updateSessions({
            id : data.id,
            duration : data.duration,
            title : data.title,
        });
    }

    deleteFilm(id) {
        const film = this.section.querySelector(`.conf-step__movie[data-id_movie="${id}"]`);
        film.remove();

        this.deleteSessions(id);
    }
    
// -------------------------- 

    showAddSession(data) { // открыть поп-ап добавить сессию 
        // формируем актуальные названия фильмов
        const select = this.addSessionModal.querySelector('select');
        
        if(select.children.length) select.innerHTML = '';

        data.forEach(film => {
            const option = this.createEl('option', null, null, film.title);
            option.value = film.id;
            select.append(option);
        })

        this.addSessionModal.classList.add('wrapper-modal_active');
    }

    hideAddSession() { // закрыть поп-ап добавить сессию  
        this.addSessionModal.classList.remove('wrapper-modal_active');
    }

    showEditSession(data) { // открыть поп-ап обновить сессию 
        const form = this.editSessionModal.querySelector('form');

        form.dataset.id_session = data.id;

        form.children[0].textContent = data.film_name;

        const sessionTime = data.session_time.split(':');
        form.hour.value = sessionTime[0];
        form.min.value = sessionTime[1];

        this.editSessionModal.classList.add('wrapper-modal_active');
    }

    hideEditSession() {
        const form = this.editSessionModal.querySelector('form');

        form.dataset.id_session = '';

        form.children[0].textContent = '';

        this.editSessionModal.classList.remove('wrapper-modal_active');
    }

    renderSession(data) {
        const session = this.paternSession(data);
        
        // находим нужный таймлайн
        const timeLine = this.section.querySelector(`[data-id_hall="${data.hall_id}"]`);

        timeLine.append(session);
    }

    // обновление нескольких сеансов (при обновлении фильма)
    updateSessions(data) {
        const sessions = this.section
            .querySelectorAll(`.conf-step__seances-movie[data-of_movie="${data.id}"]`);

        [...sessions].forEach(item => {
            item.style.width = (+data.duration / 2) + 'px';
            item.children[0].textContent = data.title;
        })
    }
    
    // обновление одного сеанса
    updateSession(data) {
        const session = this.section
            .querySelector(`.conf-step__seances-movie[data-id="${data.id}"]`);

        session.remove();

        this.renderSession(data);
    }

    deleteSessions(id) {
        console.log(id)
        const sessions = this.section.querySelectorAll(`.conf-step__seances-movie[data-id="${id}"]`);

        [...sessions].forEach(session => session.remove()); 
    }

// ---------------- PATTERNS

    patternFilm(data) {
        const div = this.createEl('div', ['conf-step__movie']);
        div.dataset.id_movie = data.id;

        const url = data.poster;
        const img = this.createEl('img', ['conf-step__movie-poster'], url);

        const title = data.title;
        const h3 = this.createEl('h3', ['conf-step__movie-title'], null, title);

        const duration = data.duration;
        const p = this.createEl('p', ['conf-step__movie-duration'], null, duration);

        div.append(img);
        div.append(h3);
        div.append(p);

        return div;
    }

    paternSession(data) {
        const div = this.createEl('div', ['conf-step__seances-movie']);
        div.style.width = (+data.duration / 2) + 'px'; 
        div.style.left = ((+data.start_h * 60 + +data.start_m) / 2) + 'px';
        div.dataset.id = data.id;
        div.dataset.of_movie = data.film_id;
        const movie = this.section.querySelector(`[data-id_movie="${data.film_id}"]`);
        const color = getComputedStyle(movie).backgroundColor;
        div.style.backgroundColor = color;

        const p1 = this.createEl('p', ['conf-step__seances-movie-title'], null, data.film_name);

        const p2 = this.createEl(
            'p', 
            ['conf-step__seances-movie-start'], 
            null, 
            data.start_h + ':' + data.start_m
        );

        div.append(p1);
        div.append(p2);

        return div;
    }

    createEl(tag, classes = null, url = null, content = null) {
        const el = document.createElement(tag);

        if(classes) el.classList.add(...classes);

        if(content) el.textContent = content;

        if(url) el.src = url;

        return el;
    }
}