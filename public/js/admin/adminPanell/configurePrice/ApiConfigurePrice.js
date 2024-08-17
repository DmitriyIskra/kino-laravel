export default class ApiConfigurePrice {
    constructor(token) {
        this.token = token;
    }

    create() {

    }

    async read() {
        
    }

    async update(data) {
        try {
            
        } catch (error) {
            throw new Error( 
                'Запрос на сохранение стоимости по типу кресла завершился ошибкой' 
                + '' 
                + error
            ) 
        }

        
    }

    delete() {

    }
}
