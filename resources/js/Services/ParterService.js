import { request } from "../Util/requestObject";
import { PartnerDomain } from "../env";

function getAll() {
    return request({
        method: "GET",
        url: `${PartnerDomain}/list`
    })
}
function findById(partnerId) {
    return request({
        method: "GET",
        url: `${PartnerDomain}/${partnerId}/find`
    })
}
export const PartnerService = {
    getAll,
    findById,

}






