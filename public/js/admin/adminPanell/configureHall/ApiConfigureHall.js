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

                return result.response;
            } catch (error) {
                throw new Error( 
                    'Запрос на получение данных зала завершился ошибкой' 
                    + '' 
                    + error
                ) 
            }
        }
    }

    async update(data) {
        try {
            const response = await fetch('/update_hall_places', {
                method : "POST",
                headers : {
                    "X-CSRF-TOKEN" : this.token,
                    "Content-Type" : "application/json",
                },
                body : JSON.stringify(data),
            }) 

            const result = await response.json();
            console.log(result)
            return true;
        } catch (error) {
            throw new Error( 
                'Запрос на сохранение данных зала и мест завершился ошибкой' 
                + '' 
                + error
            ) 
        }

        
    }

    delete() {

    }
}