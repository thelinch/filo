import React, { useState } from "react";

export const SearchContext = React.createContext();
export const SearchProvider = (props) => {
    const [favorites, setFavorites] = useState([]);
    const { favoriteselect, setFavoriteselect } = useState(null);
    const [categories, setCategories] = useState([]);
    return <SearchContext.Provider value={{ setFavorites: setFavorites, selectFavorite: favoriteselect, setFavorite: setFavoriteselect, categories: categories, favorites: favorites, setCategories: setCategories }}>
        {props.children}
    </SearchContext.Provider>
}