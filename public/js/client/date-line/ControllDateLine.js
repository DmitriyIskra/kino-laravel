export default class ControllDateLine {
    constructor(r) {
        this.r = r;
        
        this.lastActiveDate = this.r.section.querySelector('.page-nav__day_chosen');

        this.click = this.click.bind(this);
    }

    init() {
        this.registerEvents();
    }

    registerEvents() {
        this.r.section.addEventListener('click', this.click);
    }

    click(e) {
        // меняем дату по нажатию на конкретную дату
        if(e.target.closest('.page-nav__day_num')) {
            const target = e.target.closest('.page-nav__day_num');

            // меняем активную дату и сразу перерегистриуем lastActiveDate
            this.lastActiveDate = this.r.changeDate(this.lastActiveDate, target);
        }

        // меняем дату по нажатию на стрелочку
        if(e.target.closest('.page-nav__day_next')) {
            const nextDate = this.lastActiveDate.nextElementSibling;

            // меняем активную дату и сразу перерегистриуем lastActiveDate
            this.lastActiveDate = this.r.changeDate(this.lastActiveDate, nextDate);
        }
    }
}