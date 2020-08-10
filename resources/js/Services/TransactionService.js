const { request } = require("../Util/requestObject");
import { TransactionDomain, CredentialDomain, PartnerDomain } from "../env"
function save(buyBody) {
    return request({
        method: "post",
        url: `${TransactionDomain}/save`,
        data: buyBody
    })
}
function listFindPartner() {
    return request({
        method: "get",
        url: `${PartnerDomain}/transactions`
    });
}
function listFindUser() {
    return request({
        method: "get",
        url: `${CredentialDomain}/transactions`
    })
}
export const TransactionService = {
    save,
    listFindUser,
    listFindPartner
}