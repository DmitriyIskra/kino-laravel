export default class ApiSessionGrid {
    constructor(token) {
        this.token = token;
    }

    async saveFilm(data) {
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

    async saveSession(data) {
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