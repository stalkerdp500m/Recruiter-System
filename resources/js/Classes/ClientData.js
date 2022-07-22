import { ref } from "vue";

export default class {
    /**
     * properies
     * @param string pasport - Паспорт клиента
     */
    pasport = "";
    haveResults = ref(false);
    name = "";
    payments = [];
    salaries = [];
    countPayments = 0;
    maxPaymentDate = 0;
    maxWorkDate = 0;
    countWorks = 0;
    sumHours = 0;
    sequencePeriods = {};

    constructor(pasport) {
        if (pasport) {
            this.pasport = pasport;
            this.getClientData();
        }
    }

    getClientData() {
        axios
            .get("/clients", { params: { pasport: this.pasport } })
            .then((response) => {
                if (response.status == "200") {
                    this.haveResults.value = true;
                    this.name = response.data.searchResults.name;
                    if (response.data.searchResults) {
                        this.agregate(response.data.searchResults);
                    }
                }
            });
    }

    agregate(clientData) {
        if (clientData?.payments) {
            this.payments = clientData.payments;
            clientData.payments.map((paym) => {
                let datePayment = new Date(paym.year, paym.month - 1);
                if (paym.bonus > 0) {
                    this.countPayments++;
                    if (datePayment > this.maxPaymentDate) {
                        this.maxPaymentDate = datePayment;
                    }
                }
            });
        }
        let lastPeriod = { year: 0, month: 0 };
        let countSequence = 1;
        if (clientData?.salaries) {
            this.salaries = clientData.salaries;
            clientData.salaries.map((salary) => {
                let dateSalary = new Date(salary.year, salary.month - 1);
                this.countWorks++;
                this.sumHours += salary.hours;
                if (dateSalary > this.maxWorkDate) {
                    this.maxWorkDate = dateSalary;
                }
                if (
                    lastPeriod.month +
                        12 * lastPeriod.year -
                        (salary.month + 12 * salary.year) ==
                    countSequence
                ) {
                    countSequence++;
                    this.sequencePeriods[
                        `${lastPeriod.month}-${lastPeriod.year}`
                    ] = {
                        count: countSequence,
                        started: `${salary.month}-${salary.year}`,
                    };
                } else {
                    countSequence = 1;
                    lastPeriod.year = salary.year;
                    lastPeriod.month = salary.month;
                }
            });
        }
    }

    toLocaleDate(date) {
        if (date instanceof Date) {
            return date.toLocaleDateString("ru-RU", {
                year: "numeric",
                month: "numeric",
            });
        }
        return false;
    }

    get maxWorkDateLocal() {
        return this.toLocaleDate(this.maxWorkDate);
    }
    get maxPaymentDateLocal() {
        return this.toLocaleDate(this.maxPaymentDate);
    }
}
