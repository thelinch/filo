import { request } from "../Util/requestObject";
import { CategoryDomain } from "../env";

function getAll() {
    return request({
        method: "GET",
        url: `${CategoryDomain}/all`
    })
}
export const CategoryService = {
    getAll
}






