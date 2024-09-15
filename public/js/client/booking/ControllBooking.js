export default class ControllBooking {
    constructor(redraw, api) {
        this.r = redraw;
        this.api = api;

        this.click = this.click.bind(this);
    }

    init() {
        this.registerEvents();
    }

    registerEvents() {
        this.r.section.addEventListener('click', this.click);
    }

    click(e) {
        // выбор места
        if(e.target.closest('.buying-scheme__row > .buying-scheme__chair')) {
            const element = e.target.closest('.buying-scheme__row > .buying-scheme__chair');

            this.r.choosePlace(element);
        }

        // кнопка забронировать 
        if(e.target.closest('.acceptin-button')) {
            const button = e.target.closest('.acceptin-button');
            const data = this.r.storage.__get();

            if(data.length) {
                (async () => {
                    try {
                        const result = await this.api.create(data);

                        if(result.status) {
                            location.href = `/payment/${result.id}`;  
                        }
                    } catch (error) {
                        
                    }
                })()

            };

            // если места не выбраны, и нажали кнопку забронировать
            if(!data.length) {
                const notChoosed = button.previousElementSibling;
                
                this.r.__notChoosed();
            }
        }
    }
}