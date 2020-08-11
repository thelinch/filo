import { combineReducers, createStore } from "redux";
import { sidebarReducer, authReducer, userActionReducer } from "./redux/reducers/index";

const reducer = combineReducers({
    sidebar: sidebarReducer,
    auth: authReducer,
    userActions: userActionReducer
})

const store = createStore(reducer)

export default store;