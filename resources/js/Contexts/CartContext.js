import React, { useState } from "react";
import { hasContentObject } from "../Util/Util"
export const CartContext = React.createContext();
export const CartProvider = (props) => {
    const [items, setItems] = useState([]);
    const addToCart = (itemP) => {
        let newItems = items;
        if (hasContentObject(items, itemP)) {
            let indexItem = newItems.findIndex(item => item.id == itemP.id)
            newItems[indexItem].incrementQuantity();
        } else {
            newItems.push(itemP)
        }
        setItems(curr => [...newItems])
    }
    return <CartContext.Provider value={{ addToCart, items: items }}>
        {props.children}
    </CartContext.Provider>
}