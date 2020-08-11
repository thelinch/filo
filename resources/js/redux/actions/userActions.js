export const USER_BUSINESS_SAVE_SUCCESS = 'USER_BUSINESS_SAVE_SUCCESS';
export const USER_LOGOUT = "USER_LOGOUT"
export function businessSaveSuccess() {
    return {
        type: USER_BUSINESS_SAVE_SUCCESS,
    };
}
export function userLogout() {
    return { type: USER_LOGOUT }
}
