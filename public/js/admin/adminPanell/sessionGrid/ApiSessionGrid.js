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

        if(action === 'film') {
            try {
                const response = await fetch(`/get_film/${id}`);

                const result = await response.json();

                return result;
            } catch (error) {
                throw new Error('Ошибка при получении фильма');
            }
        }

        if(action === 'films') {
            try {
                const response = await fetch(`/get_all_films`);

                const result = await response.json();
                
                if(result.status) {
                    return result.films;
                }
            } catch (error) {
                throw new Error('Ошибка при получении фильмов');
            }
        }
    }

    async update(action, data) {
        if(action === 'film') {
            try {
                const response = await fetch('update_film', {
                    method : "POST",
                    headers : {
                        "X-CSRF-TOKEN" : this.token,
                    },
                    body : data,
                })
    
                const result = await response.json();

                return result.body;
            } catch (error) {
                throw new Error('Ошибка при обновлении фильма');
            }
        }

        if(action === 'session') {
            try {
                const response = await fetch('/update_session', {
                    method : "POST",
                    headers : {
                        "X-CSRF-TOKEN" : this.token,
                    },
                    body : data,
                })
    
                const result = await response.json();

                if(result.status) return result.body;
            } catch (error) {
                throw new Error('Ошибка обновления сеанса')
            }
        }
    }

    async delete(action, id) {
        if(action === 'film') {
            try {
                const response = await fetch(`/destroy_film/${id}`, {
                    method : 'DELETE',
                    headers : {
                        "X-CSRF-TOKEN" : this.token,
                    }
                })
    
                const result = await response.json();
    
                if(result.status) return result.status;
            } catch (error) {
                throw new Error('Ошибка при удалении фильма');
            }
        }

        if(action === 'session') {
            try {
                const response = await fetch(`/destroy_session/${id}`, {
                    method : 'DELETE',
                    headers : {
                        "X-CSRF-TOKEN" : this.token,
                    }
                })
    
                const result = await response.json();

                if(result.status) return result.status;
            } catch (error) {
                throw new Error('Ошибка при удалении фильма');
            }
        }
    }

}