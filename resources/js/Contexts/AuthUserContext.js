import React, { useState } from "react";

export const AuthUserContext = React.createContext();
export const AutUserProvider = (props) => {
    const userAuthenticated = JSON.parse(localStorage.getItem("user"));
    const [userAuth, setUserAuth] = useState(userAuthenticated)
    const setUserAuthenticated = (user) => {
        let userString = JSON.stringify(user)
        localStorage.setItem("user", userString)
        setUserAuth(user)
        setUserIsAdmin(user.roles.includes("administrator"))
    }
    const [userIsAdmin, setUserIsAdmin] = useState(userAuthenticated ? userAuthenticated.roles.includes("administrator") : false);
    const setUserIsAdminAuth = () => {
        const userAuthenticated = JSON.parse(localStorage.getItem("user"));
        userAuthenticated.roles = [...userAuthenticated.roles, "administrator"]
        localStorage.setItem("user", JSON.stringify(userAuthenticated))
        setUserIsAdmin(true)
    }
    return < AuthUserContext.Provider value={{ userAuth, setUserAuthenticated, userIsAdmin, setUserIsAdminAuth }
    } >
        {props.children}
    </AuthUserContext.Provider >
}