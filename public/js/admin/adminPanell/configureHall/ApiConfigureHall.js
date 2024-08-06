export default class ApiConfigureHall {
    constructor(token) {
        this.token = token;
    }

    create() {

    }

    async read(action, id) {
        
        if(action === 'hall') { 
            try {
                const response = await fetch(`/get_data_hall/${id}`);

                const result = await response.json();
            } catch (error) {
                throw new Error(
                    'Запрос на получение данных зала завершился ошибкой' 
                    + '' 
                    + error
                ) 
            }
        }
    }

    update() {

    }

    delete() {

    }
}