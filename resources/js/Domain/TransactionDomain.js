import Moment from "moment";
import { extendMoment } from "moment-range";

const moment = extendMoment(Moment);
moment.locale("es");
class TransactionDomain {
    constructor(id, items, total, state, code, phone, direction, amountpayment, created_at) {
        this._id = id;
        this._items = items;
        this._total = total;
        this._state = state;
        this._code = code;
        this._phone = phone;
        this._direction = direction;
        this._amountpayment = amountpayment;
        this._created_at = created_at;
    }
    get transformDateToLenguageHuman() {
        return moment(this._created_at).fromNow()
    }
    get color() {
        let color = ""
        switch (this._state) {
            case "Recibido":
                color = "green";
                break;
            case "En Camino":
                color = "blue"
                break;
            default:
                color = "yellow"


        }
        return color;
    }
    get total() {
        return this._total
    }
    get direction() {
        return this._direction
    }
    get items() {
        return this._items
    }
    get code() {
        return this._code
    }
    get phone() {
        return this._phone
    }
    set business(business) {
        this._business = business;
    }
    get id() {
        return this._id;
    }

    get amountpayment() {
        return this._amountpayment
    }
    get state() {
        return this._state
    }
    get business() {
        return this._business
    }
}

export default TransactionDomain;