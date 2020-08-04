export const LOGIN_SUCCESS = 'LOGIN_SUCCESS';
export const LOGOUT_SUCCESS = 'LOGOUT_SUCCESS';

export function login() {
  return {
    type: LOGIN_SUCCESS,
  };
}
export function logout() {
    return {
      type: LOGOUT_SUCCESS,
    };
  }