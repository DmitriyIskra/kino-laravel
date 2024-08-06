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
        console.log(this.redraw.hall.section)
        this.redraw.hall.section.addEventListener('click', this.click);
        this.redraw.hall.section.addEventListener('input', this.input);
    }

    click(e) {
        // -----------========= HALL
        if(e.target.closest('.conf-step__selectors-box')) {
            const id_hall = e.target.closest('li').dataset.id_hall;
            this.api.hall.read();
        }
    }

    input() {
        
    }
}