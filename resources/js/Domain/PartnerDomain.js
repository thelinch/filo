import Moment from "moment";
import { extendMoment } from "moment-range";

const moment = extendMoment(Moment);
moment.locale("es");
class PartnerDomain {
    constructor(id, description, name, dishes, category, address, phone, daysWork, city, photo) {
        this._id = id;
        this._description = description;
        this._name = name;
        this._dishes = dishes;
        this._category = category;
        this._address = address;
        this._phone = phone;
        this._daysWork = daysWork;
        this._city = city;
        this._photo = photo;
    }
    get id() {
        return this._id;
    }
    get name() {
        return this._name;
    }
    get description() {
        return this._description;
    }

    get dishes() {
        return this._dishes;
    }
    get category() {
        return this._category;
    }
    get address() {
        return this._address;
    }
    get phone() {
        return this._phone;
    }

    get dayswork() {
        return this._daysWork;
    }
    get city() {
        return this._cityy;
    }
    get photo() {
        return this._photo;
    }
    get isAvailableForAttend() {
        let isAvailableForAttend = false;
        const today = moment();
        let todayInDay = today.format("dddd")
        todayInDay = todayInDay[0].toUpperCase() + todayInDay.slice(1);
        const daywork = this._daysWork.find((daywork) => daywork.day == todayInDay);
        if (daywork) {
            const startTime = moment(daywork.startTime, "hh:mm:ss");
            const endTime = moment(daywork.endTime, "hh:mm:ss");

            isAvailableForAttend = today.isBetween(startTime, endTime);
        }
        return isAvailableForAttend;
    }
    textAlternativeForAttend() {

        const daysInWeek = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"]
        let daysworkOrder = [];
        const todayInNumber = moment().day();
        daysInWeek.forEach((element) => {
            let day = this._daysWork.find((daywork) => daywork.day == element);
            if (day) {
                daysworkOrder.push(day)
            }
        })
        let nextDayAttend = daysworkOrder[0];
        for (let i = todayInNumber; i <= 6; i++) {
            const daySearch = daysworkOrder.find((daywork) => daywork.day == daysInWeek[i])
            if (daySearch) {
                nextDayAttend = daySearch;
                break;
            }
        }
        return `Volvemos a abrir el dia  ${nextDayAttend.day} desde ${nextDayAttend.startTime} hasta  ${nextDayAttend.endTime}`;
    }
}
export default PartnerDomain;