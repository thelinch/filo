import { request } from "../Util/requestObject";
import { BusinessDomain } from "../env";

function save(business) {
    return request({
        method: "Post",
        url: `${BusinessDomain}/save`,
        data: business
    })
}
function get() {
    return request({
        method: "get",
        url: `${BusinessDomain}/get`
    });
}
function update(business) {
    return request({
        method: "Post",
        url: `${BusinessDomain}/update`,
        data: business
    })
}
function suspend(business) {


}
function deleteWorkDay(workday) {
    return request({
        method: "Post",
        data: workday,
        url: `${BusinessDomain}/deleteWorkday`
    })
}
export const BusinessService = {
    save,
    update,
    suspend,
    deleteWorkDay,
    get
}






