export default class RedrawActivationSales {
    constructor(section) {
        this.section = section;

        this.activationResult = this.section.querySelector('.conf-step__activation-result');
    
        this.timeoutID = null;
    }

    // продажи активированы
    ok() {
        this.activationResult.textContent = "Продажи активированы";
        this.clear();
    }

    // продажи не активированы
    not() {
        this.activationResult.textContent = "Продажи не активированы";
        this.clear();
    }

    clear() {
        if(this.timeoutID) clearTimeout(this.timeoutID);

        this.timeoutID = setTimeout(() => {
            this.activationResult.textContent = "";
        }, 3000)
    }
}