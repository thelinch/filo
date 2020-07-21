import { request } from "../Util/requestObject";
import { FileDomain } from "../env";

function findId(id, directory) {
    return request({
        method: "GET",
        url: `${FileDomain}find?file=${id}&&directory=${directory}`,
        responseType: "blob"
    })
}
function save(files, directory) {
    return request({
        method: "post",
        url: `${FileDomain}save?directory=${directory}`,
        data: files,
    })
}
function deletefindId(id, directory) {
    return request({
        method: "post",
        url: `${FileDomain}${id}/delete?file=${id}&&directory=${directory}`,
    })
}
export const FileService = {
    findId,
    save,
    deletefindId
}






