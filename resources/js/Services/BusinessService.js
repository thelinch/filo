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
function toogleState(business) {
    return request({
        method: "get",
        url: `${BusinessDomain}/${business.id}/delete`
    })

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
    toogleState,
    deleteWorkDay,
    get
}






