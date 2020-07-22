
import { v4 as uuidv4 } from 'uuid';


export function getObjectFindId(array, idObject) {
    return array.find((object) => object.id == idObject);
}
export function removeObjectOfArray(array, object) {

    return array.filter(item => item.id != object.id)
}
export function generateUuid() {
    return uuidv4();
}
export function transformObjectToDomainObject() {




}