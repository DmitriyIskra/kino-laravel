export default class RedrawChoosingPlace {
    constructor(section, storage) {
        this.section = section;
        this.storage = storage;

        this.notChoosed = this.section.querySelector('.not-choosed');
    }

    // выбор мест
    choosePlace(element) {
        const defaultClass = element.dataset.default_type;
        const data = {
            place_id: element.dataset.place_id, // номер места
            row_num: element.dataset.row_num, // номер зала
            price: element.dataset.price, // стоимость для сумирования
            film_id: element.dataset.film_id, // название
            session_id: element.dataset.session_id, // время
            hall_id: element.dataset.hall_id, // номер зала
        }

        // если есть надпись не выбраны места
        if (this.notChoosed.textContent) {
            this.notChoosed.textContent = '';
        }

        if (!element.classList.contains('buying-scheme__chair_selected')) {
            element.classList.remove(`buying-scheme__chair_${defaultClass}`);

            element.classList.add(`buying-scheme__chair_selected`);

            this.storage.__set(data);

            return;
        }

        element.classList.remove(`buying-scheme__chair_selected`);
        element.classList.add(`buying-scheme__chair_${defaultClass}`);
        this.storage.remove(data.place_id);
    }

    // не выбраны места
    __notChoosed() {
        this.notChoosed.textContent = 'Выберите пожалуйста места';
    }
}