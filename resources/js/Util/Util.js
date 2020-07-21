
import { v4 as uuidv4 } from 'uuid';


export function getObjectFindId(array, idObject) {
    return array.find((object) => object.id == idObject);
}

export function generateUuid() {
    return uuidv4();
}
export function transformObjectToDomainObject() {




}