import { request } from "../Util/requestObject";
import { PartnerDomain, ProductDomain } from "../env";

function getAllFindPartner(partnerId) {
    return request({
        method: "GET",
        url: `${PartnerDomain}/${partnerId}/products`
    })
}
function save(product) {
    return request({
        method: "Post",
        data: product,
        url: `${ProductDomain}/save`
    })
}
export const ProductService = {
    getAllFindPartner,
    save
}






