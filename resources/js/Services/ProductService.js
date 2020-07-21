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
function update(product) {

}
function incrementCounterFavoriteFindProduct(productId) {
    return request({
        method: "get",
        url: `${ProductDomain}/${productId}/incrementVotes`
    })
}
function deletePhotoById(productId) {
    return request(
        {
            method: "get",
            url: `${ProductDomain}/${productId}/deletePhoto`
        }
    );
}
export const ProductService = {
    getAllFindPartner,
    save,
    incrementCounterFavoriteFindProduct,
    update,
    deletePhotoById
}






