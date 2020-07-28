
import { v4 as uuidv4 } from 'uuid';


export function getObjectFindId(array, idObject) {
    return array.find((object) => object.id == idObject);
}
export function removeObjectOfArray(array, object) {

    console.log("uti", array, object)
    return array.filter(item => item.id != object.id)
}
export function hasContentObject(array, object) {

    return array.find(e => e.id == object.id) != null;
}
export function updateDayToArray(array, object) {
    let index = array.findIndex(e => e.day.id == object.day.id)
    if (index != -1) {
        array[index] = object

    }
    return array;
}

export function hasSendFileToServer(file) {
    return Object.keys(file).length > 0 && file.lastModified
}
export function hasContentDayToArray(array, object) {
    return array.find(e => e.day.id == object.day.id) != null
}
export function transformDataWeekDayToLinealObject(object) {
    let objectMap = object.days.map(dayObject => ({ startime: object.inithour, endtime: object.endhour, day: { ...dayObject } }));
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