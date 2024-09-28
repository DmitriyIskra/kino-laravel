export default class ApiConfigurePrice {
    constructor(token) {
        this.token = token;
    }

    create() {

    }

    async read(id) {
        try {
            const response = await fetch(`/get-price/${id}`);

            const result = await response.json();
   
            return result;
        } catch(error) {
            throw new Error( 
                'Запрос на получение стоимости по типу кресла завершился ошибкой' 
                + '' 
                + error
            ) 
        }
    }

    async update(data) {
        try {
            const response = await fetch('/update-hall-price', {
                method : "POST",
                headers : {
                    "X-CSRF-TOKEN" : this.token,
                    "Content-Type" : "application/json",
                },
                body : JSON.stringify(data),
            })

            const result = await response.json();

            return result.response;
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
