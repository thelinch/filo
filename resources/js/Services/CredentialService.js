import { CredentialDomain } from "../env"
import { request } from "../Util/requestObject"

function save(user) {
    return request({
        method: "Post",
        url: `${CredentialDomain}/save`,
        data: user
    })
}
function login(credentials) {
    return request({
        method: "Post",
        data: credentials,
        url: `${CredentialDomain}/login`
    })
}
function me() {
    return request({
        method: "get",
        url: `${CredentialDomain}/me`
    })
}

export const CredentialService = {
    login,
    save,
    me
}