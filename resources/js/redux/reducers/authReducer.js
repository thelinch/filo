import cookie from 'react-cookies';
import { LOGIN_SUCCESS, LOGOUT_SUCCESS } from "../actions/authActions";


const initialState = {
  isAuthenticated: !!cookie.load('token')
};
console.log(initialState)
export default function (state = initialState, action) {
  switch (action.type) {
    case LOGIN_SUCCESS:
      return { ...state, isAuthenticated: true };
    case LOGOUT_SUCCESS:
      return { ...state, isAuthenticated: false };
    default: {
      return state;
    }
  }
}