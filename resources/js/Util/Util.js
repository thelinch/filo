
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