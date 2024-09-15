export default class ApiBooking {
    constructor(token) {
        this.token = token;
    }

    async create(data) {
        try {
            const response = await fetch('/booking', {
                method : "POST",
                headers : {
                    "X-CSRF-TOKEN" : this.token,
                    "Content-Type" : "application/json",
                },
                body : JSON.stringify(data),
            })

            const result = await response.json();
            return result;
        } catch (error) {
            console.log(error)
        }
        
    }

    async read() {

    }

    async update() {

    }

    async delete() {

    }
}