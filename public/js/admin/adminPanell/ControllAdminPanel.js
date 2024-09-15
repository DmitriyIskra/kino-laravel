export default class ControllAdminPanel {
    constructor(redraw, api) {
        this.redraw = redraw;
        this.api = api;

        this.click = this.click.bind(this);
        this.input = this.input.bind(this);
        this.submit = this.submit.bind(this);

        // стартовые значения конфигурации зала к 
        // которым можно сбросить при нажатии кнопки отмена
        this.initialData = {
            row : null,
            amount : null,
            typePlaces : [],
        }

        // стартовые значения стоимости кресла
        this.initialPrice = {
            standart : null,
            vip : null,
        }

        // новые данные о количестве мест и рядов
        // если были изменения
        this.newPlaces = {
            row: null,
            amount: null,
        }

        // новые данные о типах кресел если были изменения
        this.newTypePlaces = [];

        // новые данные о стоимости кресел
        this.newPrice = {
            standart : null,
            vip : null,
        }
        
        // активный зал для добавления сессии
        this.activeHallForSession = null;
    }

    init() {
        this.registerEvents(); 

        this.parseInitialData('places');
        this.parseInitialData('prices');

        this.initSessions();
    }

    initSessions() {
        (async () => {
            const sessions = await this.api.session.read('all_sessions');

            sessions.forEach(item => {
                this.redraw.session.renderSession(item);
            })
        })()
    }

    registerEvents() {
        // конфигурация зала
        this.redraw.hall.section.addEventListener('click', this.click);
        this.redraw.hall.section.addEventListener('input', this.input);
        // конфигурация цен
        this.redraw.price.section.addEventListener('click', this.click);
        this.redraw.price.section.addEventListener('input', this.input);
        // сетка сеансов
        this.redraw.session.section.addEventListener('click', this.click);
        // модалки редактивария/добавления фильмов
        this.redraw.session.filmModal.addEventListener('submit', this.submit);
        this.redraw.session.filmEditModal.addEventListener('submit', this.submit);
        // модалки редактивария/добавления сессий
        this.redraw.session.addSessionModal.addEventListener('submit', this.submit);
        this.redraw.session.editSessionModal.addEventListener('submit', this.submit);
        // активация продаж
        this.redraw.activation.section.addEventListener('click', this.click);
    }

    click(e) { 
        // -----------========= CONFIGURE HALL
        // -----------============ выбираем зал
        if(e.target.closest('.conf-step__selectors-hall')) {
            const id_hall = this.parseActiveHall(this.redraw.hall.hallsButtons);
            (async () => {
                const result = await this.api.hall.read('hall', id_hall);
                this.redraw.hall.renderHall(result.row, result.place, result.chairs); // !!!!!!!!!!!!!!!!!
                this.redraw.hall.renderValues(result.row, result.place);

                this.parseInitialData('places');
                // данные только загружены ничего не менялось кнопку выключаем
                this.redraw.hall.stateButtonSave('off'); 
            })()
        }

        // -----------============ меняем CHAIR TYPE
        if(e.target.closest('.conf-step__chair')) {
            const el = e.target;
            this.redraw.hall.changeHall(el);
            this.redraw.hall.stateButtonSave('on');

            // сохраняем измененные креасла
            // актуальный список мест и типов
            this.newTypePlaces = [...this.parseTypePlaces()];
            
            // обновляем количество мест и рядов
            const obj = this.parseRowAmount();
            this.newPlaces.row = obj.rows;
            this.newPlaces.amount = obj.places;
        }

        // --------------============ сброс внесенных изменений
        if(e.target.closest('.configure-hall__reset')) {
            // нужно сбрасывать не просто к нулю, а к первоначальному значению
            this.redraw.hall.renderHall(
                this.initialData.row, 
                this.initialData.amount,
                this.initialData.typePlaces
            );

            this.redraw.hall.renderValues(this.initialData.row, this.initialData.amount);
            
            /** данные были сброшены в первоначальное значение, сохранять нечего */ 
            this.redraw.hall.stateButtonSave('off');
        }

        // --------------============ Сохраняем изменения на сервер
        if(e.target.closest('.configure-hall__accent')) {
            const id_hall = this.parseActiveHall(this.redraw.hall.hallsButtons);

            (async () => {
                const data = {
                    id_hall,
                    amount_places : this.newPlaces,
                    typesPlaces : this.newTypePlaces,
                }

                try {
                    await this.api.hall.update(data);
                } catch {
                    // нужно сбрасывать не просто к нулю, а к первоначальному значению
                    this.redraw.hall.renderHall(
                        this.initialData.row, 
                        this.initialData.amount,
                        this.initialData.typePlaces
                    );
                    this.redraw.hall.renderValues(this.initialData.row, this.initialData.amount);
                }

                /** данные были сброшены в первоначальное значение, сохранять нечего */ 
                this.redraw.hall.stateButtonSave('off');
            })()
        }

        // -----------========= CONFIGURE PRICE
        // --------------============ выбираем зал
        if(e.target.closest('.conf-step__selectors-price')) {
            const id_hall = this.parseActiveHall(this.redraw.price.hallsButtons);
            (async () => {
                const result = await this.api.price.read(id_hall);
                
                this.redraw.price.renderValues(result.price_standart, result.price_vip);

                this.parseInitialData('prices');
                // данные только загружены ничего не менялось кнопку выключаем
                this.redraw.hall.stateButtonSave('off'); 
            })()
        }

        // --------------============ сброс внесенных изменений
        if(e.target.closest('.configure-price__reset')) {
            this.redraw.price.renderValues(this.initialPrice.standart, this.initialPrice.vip);
            
            /** данные были сброшены в первоначальное значение, сохранять нечего */ 
            this.redraw.hall.stateButtonSave('off');
        }

        // --------------============ Сохраняем изменения на сервер
        if(e.target.closest('.configure-price__accent')) {
            const id_hall = this.parseActiveHall(this.redraw.price.hallsButtons);;

            (async () => {
                const data = {
                    id_hall,
                    price_places : this.newPrice,
                }

                try {
                    await this.api.price.update(data);
                } catch {
                    // нужно сбрасывать не просто к нулю, а к первоначальному значению
                    this.redraw.price.renderValues(
                        this.initialPrice.standart, this.initialPrice.vip
                    );
                }

                /** данные были сброшены в первоначальное значение, сохранять нечего */ 
                this.redraw.price.stateButtonSave('off');
            })()
        }

        // -----------========= SESSION GRID
        // подвязать в миграциях сеансы к залу, если удаляем зал то и сеансов в нем не будет
        // сначала добавляем фильм, без фильма сеанс не возможен и без зала сеанс не возможен
        // для добавления фильма нужна модалка
        
        // --------- Фильмы
        // модалка для добавления фильма показ
        if(e.target.closest('.conf-step__add-film')) {
            this.redraw.session.showModalFilm();
        }
        // модалка для обновления фильма (открытие)
        if(e.target.closest('.conf-step__movie')) {
            const element = e.target.closest('.conf-step__movie');
            const id = element.dataset.id_movie;

            (async () => {
                // получаем данные о фильме для заполнения модалки
                const film = await this.api.session.read('film', id);
                this.redraw.session.showModalEditFilm(film);
            })()

        }
        // закрытие модалки для добавления фильма
        if(e.target.closest('.film__add-reset')) {
            this.redraw.session.hideModalFilm();
        }
        // закрытие модалки для обновления фильма
        if(e.target.closest('.film__update-reset')) {
            this.redraw.session.hideModalEditFilm();
        }
        // Удаление фильма
        if(e.target.closest('.film__button-delete')) {
            const form = e.target.closest('form');
            const filmId = form.dataset.film_id;

            (async () => {
                const result = this.api.session.delete('film', filmId);

                if(result) this.redraw.session.deleteFilm(filmId);

                this.redraw.session.hideModalEditFilm();
            })()
        }


        // --------- Сеансы
        // модалка для добавления сеанса показ
        if(e.target.closest('.conf-step__seances-timeline') &&
        !e.target.closest('.conf-step__seances-movie')) {
            const target = e.target.closest('.conf-step__seances-timeline');

            // Для последующей отрисовки сеанса на странице в нужном timeline
            this.activeHallForSession = +target.dataset.id_hall;
            // вставляем в модалку актуальные названия фильмов
            (async () => {
                const data = await this.api.session.read('films');

                this.redraw.session.showAddSession(data);
            })()
        } 

        // закрытие модалка для добавления сеанса
        if(e.target.closest('.session__add-reset')) {
            this.redraw.session.hideAddSession();
        }

        // модалка для обновления сеанса показ
        if(e.target.closest('.conf-step__seances-movie')) {
            const session = e.target.closest('.conf-step__seances-movie');
            const id = session.dataset.id;
            const film_name = session.children[0].textContent;
            const session_time = session.children[1].textContent;

            this.redraw.session.showEditSession({id, film_name, session_time});
        }

        // закрытие модалка для обновления сеанса
        if(e.target.closest('.session__update-reset')) {
            this.redraw.session.hideEditSession();
        }

        // удаление сеанса
        if(e.target.closest('.session__button-delete')) {
            const form = e.target.closest('form');

            const id = form.dataset.id_session;

            (async () => {
                const result = await this.api.session.delete('session', id);

                this.redraw.session.hideEditSession();

                if(result) this.redraw.session.deleteSessions(id);
            })()
        }


        // --------- Открыть продажу билетов
        if(e.target.closest('.conf-step__button-activate-sales')){
            (async () => {
                const response = await this.api.activation.update('activate_sales');

                if(response) this.redraw.activation.ok();

                if(!response) this.redraw.activation.not();
            })()
        }
    }

    input(e) {
        // -----------========= HALL
        let obj = null;

        if(e.target.closest('.conf-step__input-row') 
        || e.target.closest('.conf-step__input-place')) {
            obj = this.parseRowAmount();
        }
        
        // включаем/выключаем кнопку сохранения, если нет мест то и сохранять нет смысла
        if(obj?.places) {
            // формируем места
            this.redraw.hall.renderHall(obj.rows, obj.places, null);

            this.redraw.hall.stateButtonSave('on');

            // сохраняем изменения о количестве рядов и мест
            this.newPlaces.row = obj.rows;
            this.newPlaces.amount = obj.places;

            // сохраняем актуальный список мест и типов
            this.newTypePlaces = [...this.parseTypePlaces()];
        } 
        if(!obj?.rows || !obj?.places) {
            this.redraw.hall.stateButtonSave('off');
        }

        // -----------========= PRICE
        let objPrices = null;

        if(e.target.closest('.conf-step__input-standart') 
        || e.target.closest('.conf-step__input-vip')) {
            objPrices = this.parsePrice();
        }

        // включаемкнопку сохранения, если нет цен то и сохранять нечего
        if(objPrices?.standart || objPrices?.vip) {
            this.redraw.price.stateButtonSave('on');

            // сохраняем изменения о количестве рядов и мест
            this.newPrice.standart = objPrices.standart;
            this.newPrice.vip = objPrices.vip;
        } 
        // выключаем кнопку сохранения
        if(!objPrices?.standart && !objPrices?.vip) {
            this.redraw.hall.stateButtonSave('off');
        }
    }

    submit(e) {
        e.preventDefault();
        // ===== ФИЛЬМЫ
        // создание фильма
        if(e.target.closest('.film__add-form')) {
            const formData = new FormData(e.target); 
            (async () => {
                const result = await this.api.session.create('film', formData);

                this.redraw.session.renderFilm(result);

                this.redraw.session.hideModalFilm(); 
                e.target.reset();       
            })();
        }
        // обновление фильма
        if(e.target.closest('.film__update-form')) {
            (async () => {
                const formData = new FormData(e.target); 

                const film_id = e.target.dataset.film_id;
                formData.append('film_id', film_id);

                const result = await this.api.session.update('film', formData);

                this.redraw.session.hideModalEditFilm(); 

                e.target.reset();   
                
                this.redraw.session.updateFilm(result);
            })();
        }

        // ===== СЕАНСЫ
        // добавление сеанса
        if(e.target.closest('.session__add-form')) {
            this.activeHallForSession;

            (async () => {
                const formData = new FormData(e.target);
                formData.append('id_hall', this.activeHallForSession);

                const result = await this.api.session.create('session', formData);
                this.redraw.session.renderSession(result);

                e.target.reset();

                this.redraw.session.hideAddSession();
            })();
        }
        // редактирование сеанса
        if(e.target.closest('.session__update-form')) {
            const form = e.target.closest('.session__update-form');

            const id = form.dataset.id_session;

            (async () => {
                const formData = new FormData(form);
                formData.append('id', id);

                const result = await this.api.session.update('session', formData);
                console.log(result)
                this.redraw.session.updateSession(result);

                e.target.reset();

                this.redraw.session.hideEditSession();
            })()
        }
    }
 

// -------------------------------------------------------------------------------
//              ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ

    // сохраняем стартовые значения для кнопки отмена
    // и возвращению к первоначальному состоянию
    // при конфигурации зала и цен
    parseInitialData(action) {
        if(action === 'places') {
            // данные конфигурации зала (кресел)
            const rows = this.redraw.hall.row.value;
            const places = this.redraw.hall.place.value;
    
            if(rows && places) {
                const arr = this.parseTypePlaces();
    
                this.initialData.row = rows;
                this.initialData.amount = places;
                this.initialData.typePlaces = [...arr];
            } else {
                this.initialData.row = null;
                this.initialData.amount = null;
                this.initialData.typePlaces = [];
            }
        }

        if(action === 'prices') {
            // данные конфигурации цен
            this.initialPrice.standart = +this.redraw.price.standart.value || null;
            this.initialPrice.vip = +this.redraw.price.vip.value || null;
        }
    }

    /** Собирает и возвращает массив объектов {id, type} */
    parseTypePlaces() {
        this.newTypePlaces.length = 0;

        const arr = [];

        [...this.redraw.hall.hallWrapper.children].forEach(item => {
            const part = [];
            [...item.children].forEach(place => {
                const chair_num = +place.dataset.chair_num;
                const type = place.dataset.place_type;
                part.push({chair_num, type});
            })
            arr.push(part);
        });
        // console.log(arr)
        return arr;
    }

    // сбор данных о введенных количестве рядов и мест
    // если вводить что то кроме цифр, ничего не будет отрисовываться
    parseRowAmount() {
        const rows = +this.redraw.hall.row.value || 0;
        const places = +this.redraw.hall.place.value || 0;

        this.validateInput([
            {
                val : rows,
                input : this.redraw.hall.row,
            }, {
                val : places,
                input : this.redraw.hall.place,
            }
        ]);

        return {rows, places};
    }

    // сбор цен из input (ввод только цифр) (мини валидация)
    parsePrice() {
        let standart = +this.redraw.price.standart.value || null;
        let vip = +this.redraw.price.vip.value || null;

        this.validateInput([
            {
                val : standart,
                input : this.redraw.price.standart,
            }, {
                val : vip,
                input : this.redraw.price.vip,
            }
        ]);

        if(standart || vip) return {standart, vip};
    }

    // если вводят не цифры, очищаем ввод (не даем вводить не цифры)
    validateInput(data) {
        data.forEach(item => {
            if(!item.val) item.input.value = '';
        })
    }

    // поиск активного зала конфигурации зала
    parseActiveHall(selectors) {
        let activeButtonHall = null;
        if(selectors && selectors.length) {
            activeButtonHall = [...selectors] 
                .find(item => item.checked);
        }

        return +activeButtonHall.dataset.id_hall;
    }
}