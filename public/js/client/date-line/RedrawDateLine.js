export default class RedrawDateLine {
    constructor(section) {
        this.section = section;

        // первая дата по счету на линии
        this.firstElementDate = 
            this.section.querySelectorAll('.page-nav__day_num')[0];
        // ссылки с сеансами
        this.linksOfSessions = document.querySelectorAll('.movie-seances__time');
    }

    changeDate(lastDate, newDate) {
        lastDate.classList.remove('page-nav__day_chosen');
        // если новый элемент это стрелка переопределяем его на первую дату в списке
        if(newDate.closest('.page-nav__day_next')) newDate = this.firstElementDate;
        newDate.classList.add('page-nav__day_chosen');

        return newDate;
    }

    // прописывает выбранную дату в ссылку как параметр
    changeLinks(number) {
        const date = new Date();
        const month = date.getMonth().toString().padStart(2, 0);
        const year = date.getFullYear();

        const fullDate = `${number}.${month}.${year}`;
        
        // перебираем ссылки с сессиями
        [...this.linksOfSessions].forEach(session => {
            let href = session.href;
            session.href = ''; // очищаем

            const regExp = /https:\/\/kinizal\/hall\/\d{1,3}\/\d{1,2}\/\d{2}\.\d{2}\.\d{4}$/;

            const result = regExp.test(href);

            // если дата уже была установлена
            if(result) {
                const regExp = /(https:\/\/kinizal\/hall\/\d{1,3}\/\d{1,2}\/)(\d{2}\.\d{2}\.\d{4}$)/;
                href = href.replace(regExp, `$1${fullDate}`);
                session.href = href;
                return;
            }
            
            // если дата устанавливается впервые
            session.href = `${href}/${fullDate}`;
        })
    }
}