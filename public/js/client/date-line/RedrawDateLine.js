export default class RedrawDateLine {
    constructor(section) {
        this.section = section;

        // первая дата по счету на линии
        this.firstElementDate = 
            this.section.querySelectorAll('.page-nav__day_num')[0];
        // ссылки с сеансами
        this.linksOfSessions = this.section.querySelectorAll('.page-nav__day_num');
    }

    changeDate(lastDate, newDate) {
        lastDate.classList.remove('page-nav__day_chosen');
        // если новый элемент это стрелка переопределяем его на первую дату в списке
        if(newDate.closest('.page-nav__day_next')) newDate = this.firstElementDate;
        newDate.classList.add('page-nav__day_chosen');

        return newDate;
    }

    changeLinks(date) {
        // СНАЧАЛА установить стартовые значения в ссылки с сессиями с помощью php и blade
        // дальше будем в контроллере получать дату 
        // скрыто ее устанавливать на страницу
        // после нажатия забронировать добавлять в данные, одним разом, чтоб не в каждом выборе места, а один раз
        // на сервере получать и добавлять в билет
            // для этого добавить в миграцию дату бронирование
        // а также добавлять в qr чтоб там тоже была конкретная дата

        // ПОСЛЕ ВСЕГО НЕ ЗАБЫТЬ НАПИСАТЬ ИНСТРУКЦИЮ
    }
}