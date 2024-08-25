export default class RedrawSessionGrid {
    constructor(section) {
        this.section = section;

        this.wrapperMovies = this.section.querySelector('.conf-step__movies');

        this.addFilmModal = this.section.querySelector('.modal__add-film');
        this.addSessionModal = this.section.querySelector('.modal__add-session');
    }

    showAddFilm() {
        this.addFilmModal.classList.add('wrapper-modal_active');
    }

    hideAddFilm() {
        this.addFilmModal.classList.remove('wrapper-modal_active');
    }
// --------------------------
    showAddSession() {
        this.addSessionModal.classList.add('wrapper-modal_active');
    }

    hideAddSession() {
        this.addSessionModal.classList.remove('wrapper-modal_active');
    }

    renderFilm(data) {
        const film = this.patternFilm(data);

        this.wrapperMovies.append(film);
    }

// --------------------------

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
        
        console.log(div)

        return div;
    }

    createEl(tag, classes = null, url = null, content = null) {
        const el = document.createElement(tag);

        if(classes) el.classList.add(...classes);

        if(classes) el.textContent = content;

        if(url) el.src = url;

        return el;
    }
}