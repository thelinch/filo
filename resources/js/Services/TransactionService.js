const { request } = require("../Util/requestObject");
import { TransactionDomain } from "../env"
function save(buyBody) {
    return request({
        method: "post",
        url: `${TransactionDomain}/save`,
        data: buyBody
    })
}

function listFindUser() {
    return request({
        method: "get",
        url: ``
    })
}
export const TransactionService = {
    save
}