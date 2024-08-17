export default class RedrawConfigurePrice {
    constructor(section) {
        this.section = section;

        // Поля для ввода цены
        this.standart = this.section.querySelector('.conf-step__input-standart');
        this.vip = this.section.querySelector('.conf-step__input-vip');

        // Кнопки выбора зала
        this.hallsButtons = this.section.querySelectorAll('.conf-step__radio');

        // Кнопка сохранить
        this.save = this.section.querySelector('.configure-price__accent');

        // Кнопка отмена
        this.reset = this.section.querySelector('.configure-price__reset');
    }

    // заполнение input
    renderValues(standart, vip) { 
        // когда ничего не приходит убираем значение вообще    
        if(!standart) this.standart.value = ''; 
        if(!vip) this.vip.value = '';

        if(standart) this.standart.value = standart; 
        if(vip) this.vip.value = vip;
    }

    // активация/деактивация кнопки сохранения
    stateButtonSave(state) {
        if(state === 'off') this.save.classList.add('conf-step__button-accent_disabled');
        if(state === 'on') this.save.classList.remove('conf-step__button-accent_disabled');
    }
}