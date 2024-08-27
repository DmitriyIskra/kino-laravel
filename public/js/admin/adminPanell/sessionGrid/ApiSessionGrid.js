export default class ApiSessionGrid {
    constructor(token) {
        this.token = token;
    }

    async create(action, data) {
        if(action === 'film') {
            try {
                const response  = await fetch('/save_film', {
                    method : "POST",
                    headers : {
                        "X-CSRF-TOKEN" : this.token,
                    },
                    body : data,
                })
    
                const result = await response.json();
                
                if(result.result) return result.body;
            } catch (error) {
                throw new Error('Ошибка при сохранении фильма');
            }
        }

        if(action === 'session') {
            try {
                const response  = await fetch('/save_session', {
                    method : "POST",
                    headers : {
                        "X-CSRF-TOKEN" : this.token,
                    },
                    body : data,
                })
    
                const result = await response.json();
                
                if(result.result) return result.body;
            } catch (error) {
                throw new Error('Ошибка при сохранении сессии');
            }
        }
    }

    async read(action, id = null) {
        if(action === 'all_sessions') {
            try {
                const response = await fetch('/get_sessions');

                const result = await response.json();

                return result.body;
            } catch (error) {
                throw new Error('Ошибка при получении сессий');
            }
        }
    }

    async update() {

    }

    async delete() {

    }

}