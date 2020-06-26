import React, { useState } from "react";

export const SearchContext = React.createContext();
export const SearchProvider = (props) => {
    const [favorites, setFavorites] = useState([]);
    const [categories, setCategories] = useState([]);
    console.log(categories)
    return <SearchContext.Provider value={{ setFavorites: setFavorites, categories: categories, favorites: favorites, setCategories: setCategories }}>
        {props.children}
    </SearchContext.Provider>
}