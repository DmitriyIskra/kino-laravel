export default class StorageBooking {
    constructor() {
        this.storage = [];
    }

    __set(data) {
        this.storage.push(data);
    }
    
    __get() {
        return this.storage;
    }

    remove(id) {
        this.storage.forEach((item, index, array) => {
            if(item.place_id === id) {
                array.splice(index, 1);
            };
        })
    }

    destroy() {
        this.storage.length = 0;
    }
}