
import { v4 as uuidv4 } from 'uuid';


export function getObjectFindId(array, idObject) {
    return array.find((object) => object.id == idObject);
}
export function currentUserIsAdmin() {
    let user = getUser();
    return user.roles.includes("administrator");
}
export function removeObjectOfArray(array, object) {

    return array.filter(item => item.id != object.id)
}
export function hasContentObject(array, object) {

    return array.find(e => e.id == object.id) != null;
}
export function deleteElementOfArray(array, id) {
    let index = array.findIndex(object => object.id == id);
    if (index != -1) {
        array.splice(index, 1);
    }
}
export const encode = (object) => JSON.stringify(Object.entries(object));

export const decode = (string, T) => {
    const object = new T();
    JSON.parse(string).map(([key, value]) => (object[key] = value));
    return object;
}
export function transformDomainToJson(instance) {
    let object = {}
    Object.keys(instance).map((key) => (object[key.replace("_", "")] = instance[key]))
    return object;
}
export function updateDayToArray(array, object) {
    let index = array.findIndex(e => e.day.id == object.day.id)
    if (index != -1) {
        array[index] = { id: array[index].id, ...object }

    }
    return array;
}
export function agrupedTransactions(items) {

}
export function setUser(user) {
    localStorage.setItem("user", JSON.stringify(user))
}
export function getUser() {
    return JSON.parse(localStorage.getItem("user"));
}
export function removeObjectDayToArray(array, object) {
    return array.filter(item => item.day.id != object.day.id)
}
export function hasSendFileToServer(file) {
    return Object.keys(file).length > 0 && file.lastModified
}
export function hasContentDayToArray(array, object) {
    return array.find(e => e.day.id == object.day.id) != null
}
export function transformDataWeekDayToLinealObject(object) {
    let objectMap = object.days.map(dayObject => ({ startime: object.inithour, endtime: object.endhour, day: { name: dayObject.day, id: dayObject.id } }));
    return objectMap;

}
export function insertObjectToArray(array, object) {
    array.push(object)
    return array;
}
export function updateObjetToArray(array, object) {
    let index = array.findIndex(e => e.id == object.id)
    if (index != -1) {
        array[index] = object

    }
    return array;
}
export function generateUuid() {
    return uuidv4();
}
export function transformObjectToDomainObject() {




}