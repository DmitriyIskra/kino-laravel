export default class ControllAdminPanel {
    constructor(redraw, api) {
        this.redraw = redraw;
        this.api = api;

        this.click = this.click.bind(this);
        this.input = this.input.bind(this);
    }

    init() {
        this.registerEvents(); 
    }

    registerEvents() {
        this.redraw.hall.section.addEventListener('click', this.click);
        this.redraw.hall.section.addEventListener('input', this.input);
    }

    click(e) {
        // -----------========= HALL
        if(e.target.closest('.conf-step__selectors-box')) {
            const id_hall = +e.target.closest('li').dataset.id_hall;
            (async () => {
                const result = await this.api.hall.read('hall', id_hall);
                this.redraw.hall.renderHall(result.row, result.place);
                this.redraw.hall.renderValues(result.row, result.place);
                // данные только загружены ничего не менялось кнопку выключаем
                this.redraw.hall.stateButtonSave('off'); 
            })()
        }

        // -----------============ CHAIR TYPE
        if(e.target.closest('.conf-step__chair')) {
            const el = e.target;
            this.redraw.hall.changeHall(el);
            this.redraw.hall.stateButtonSave('on');
        }
    }

    input(e) {
        let rows;
        let places;
        
        if(e.target.closest('.conf-step__input-row') 
        || e.target.closest('.conf-step__input-place')) {
            rows = +this.redraw.hall.row.value || 0;
            places = +this.redraw.hall.place.value || 0;
        }
        
        // формируем места
        this.redraw.hall.renderHall(rows, places);

        // включаем/выключаем кнопку сохранения, если нет мест то и сохранять нет смысла
        if(places) {
            this.redraw.hall.stateButtonSave('on');
        } 
        if(!rows || !places) {
            this.redraw.hall.stateButtonSave('off');
        }
    }
}