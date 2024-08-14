export default class ControllAdminPanel {
    constructor(redraw, api) {
        this.redraw = redraw;
        this.api = api;

        this.click = this.click.bind(this);
        this.input = this.input.bind(this);

        // стартовые значения к которым можно сбросить
        // при нажатии кнопки отмена
        this.initialData = {
            row : null,
            amount : null,
            typePlaces : [],
        }

        // новые данные о количестве мест и рядов
        // если были изменения
        this.newPlaces = {
            row: null,
            amount: null,
        }

        // новые данные о типах кресел если были изменения
        this.newTypePlaces = [];

        // активная кнопка выбора зала
        this.activeButtonHall = null;
    }

    init() {
        this.registerEvents(); 

        this.parseInitialData();

        this.parseActiveHall();
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
                this.redraw.hall.renderHall(result.row, result.place); // !!!!!!!!!!!!!!!!!
                this.redraw.hall.renderValues(result.row, result.place);

                this.parseInitialData();

                this.parseActiveHall();
                // данные только загружены ничего не менялось кнопку выключаем
                this.redraw.hall.stateButtonSave('off'); 
            })()
        }

        // !!!!!!!!!!!! ПРИ ПЕРЕКЛЮЧЕНИИ ЗАЛА ОТРИСОВЫВАТЬ ТИПЫ КРЕСЕЛ С АКТУАЛЬНЫМИ ДАННЫМИ ИЗ БД !!!!!!!!!!!!!!!!!!

        // при нажатии на другой зал собирать новые данные о данном зале для отмена
        // подстроить новый renderHall под все функции (осталось ручное переключение залов)

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
            const id_hall = +this.activeButtonHall.dataset.id_hall;

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
    }

    input(e) {
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
    }

    // сохраняем стартовые значения для кнопки отмена
    // и возвращению к первоначальному состоянию
    parseInitialData() {
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

        return {rows, places};
    }

    // поиск активного зала
    parseActiveHall() {
        if(this.redraw.hall.hallsButtons.length) {
            this.activeButtonHall = [...this.redraw.hall.hallsButtons]
                .find(item => item.checked);
        }
    }
}