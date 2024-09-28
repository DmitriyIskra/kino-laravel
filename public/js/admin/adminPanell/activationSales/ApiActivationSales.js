export default class ApiActivationSales {
    constructor(token) {
        this.token = token;
    }

    async create() {
        
    }

    async read() {

    }

    async update() {
        try {
            const response = await fetch('/activate-sales');

            const result = await response.json();

            if(response.status) return true;

            return false;

        } catch (error) {
            throw new Error('Ошибка при активации фильмов');
        }
    }

    async delete() {

    }
}