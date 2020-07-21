import React, { useState } from "react";

export const CartContext = React.createContext();
export const CartProvider = (props) => {
    const [items, setItems] = useState([]);
    return <CartContext.Provider value={{ setItem: setItems, items: items }}>
        {props.children}
    </CartContext.Provider>
}