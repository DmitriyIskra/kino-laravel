export default class RedrawSessionGrid {
    constructor(section) {
        this.section = section;

        this.addFilmModal = this.section.querySelector('.wrapper-modal');
    }

    showAddFilm() {
        this.addFilmModal.classList.add('wrapper-modal_active');
    }

    hideAddFilm() {
        this.addFilmModal.classList.remove('wrapper-modal_active');
    }
}