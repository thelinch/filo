import { request } from "../Util/requestObject";
import { BusinessDomain } from "../env";

function save(business) {
    return request({
        method: "Post",
        url: `${BusinessDomain}/save`,
        data: business
    })
}
function update(business) {
    return request({
        method: "Post",
        url: `${BusinessDomain}/update`,
        data: business
    })
}
function deleteB(business) {

}
export const BusinessService = {
    save,
    update,
    deleteB
}






