export default class RedrawConfigureHall {
    constructor(section) {
        this.section = section;

        // input с заданным количеством рядов и мест
        this.row = this.section.querySelector('.conf-step__input-row');
        this.place = this.section.querySelector('.conf-step__input-place');

        // контейнер для отрисовки рядов и мест
        this.hallWrapper = this.section.querySelector('.conf-step__hall-wrapper');

        // Кнопка сохранить
        this.save = this.section.querySelector('.configure-hall__accent');

        // Кнопка отмена
        this.reset = this.section.querySelector('.configure-hall__reset');
    }



    changeHall(el) { 
        const type = el.dataset.place_type;

        switch(type) {
            case 'standart':
                el.classList.remove(`conf-step__chair_${type}`);
                el.classList.add(`conf-step__chair_vip`);
                el.dataset.place_type = 'vip';
            break;
            case 'vip':
                el.classList.remove(`conf-step__chair_${type}`);
                el.classList.add(`conf-step__chair_disabled`);
                el.dataset.place_type = 'disabled';
            break;
            default:
                el.classList.remove(`conf-step__chair_${type}`);
                el.classList.add(`conf-step__chair_standart`);
                el.dataset.place_type = 'standart';
        }
    }

    // заполнение input
    renderValues(rows, places) {
        // если поле заполненно а в полученных от сервера данных нет или 0 очищаем
        if(this.row.value && !rows) this.row.value = '';
        if(this.place.value && !places) this.place.value = '';
        
        if(rows) this.row.value = rows;
        if(places) this.place.value = places;
    }

    // отрисовка зала (ряды и места)
    renderHall(rows, places) {
        if(this.hallWrapper.children.length) this.hallWrapper.innerHTML = '';

        if(rows, places) {
            const elements = this.patternHall(rows, places);

            this.hallWrapper.append(...elements);
        }
    }

    // активация/деактивация кнопки сохранения
    stateButtonSave(state) {
        if(state === 'off') this.save.classList.add('conf-step__button-accent_disabled');
        if(state === 'on') this.save.classList.remove('conf-step__button-accent_disabled');
    }


    patternHall(rows, places) {
        // собираем в массив строки с содержимым
        const arr = [];
        let counter = 0

        if(rows) {
            for(let i = 0; i < rows; i += 1) {
                const div = this.createElement('div', ['conf-step__row']);
                
                if(places) {
                    for(let j = 0; j < places; j += 1) {
                        const span = this.createElement('span', ['conf-step__chair', 'conf-step__chair_standart']);
                        span.dataset.place_id = counter += 1;
                        span.dataset.place_type = 'standart';
                        div.append(span);
                    }
                }

                arr.push(div);
            }

            return arr;
        }
    }

    createElement(tag, classes = null) {
        const el = document.createElement(tag);

        if(classes) el.classList.add(...classes);

        return el;
    }
}