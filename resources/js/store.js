import { combineReducers, createStore } from "redux";
import { sidebarReducer, authReducer } from "./redux/reducers/index";

const reducer = combineReducers({
    sidebar: sidebarReducer,
    auth: authReducer
})

const store = createStore(reducer)

export default store;