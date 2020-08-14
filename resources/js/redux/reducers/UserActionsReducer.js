import cookie from 'react-cookies';

import { USER_BUSINESS_SAVE_SUCCESS, USER_LOGOUT } from "../actions/userActions";
import { currentUserIsAdmin } from '../../Util/Util';
const initialState = {
    isRoleAdmin: !!cookie.load('token') && currentUserIsAdmin()
}
export default function (state = initialState, action) {
    switch (action.type) {
        case USER_BUSINESS_SAVE_SUCCESS:
            return { ...state, isRoleAdmin: true };
        case USER_LOGOUT:
            return { ...state, isRoleAdmin: false }
        default:
            return state;


    }
}