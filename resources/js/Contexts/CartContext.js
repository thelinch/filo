import React, { useState } from "react";
import { hasContentObject, encode, decode } from "../Util/Util"
import ProductDomain from "../Domain/ProductDomain";
import { messageError } from "../Util/Swal";
export const CartContext = React.createContext();
export const CartProvider = (props) => {
    const decodeItems = (itemsEnconded) => {
        let itemsDecoded = itemsEnconded.map((itemEncoded) => (decode(itemEncoded, ProductDomain)));
        return itemsDecoded;
    }
    const encodedItems = (items) => {
        let itemsEncoded = items.map((item) => (encode(item)));
        return itemsEncoded;
    }
    const [items, setItems] = useState(localStorage.getItem("cart-items") ? decodeItems(JSON.parse(localStorage.getItem("cart-items"))) : []);
    const addToCart = (itemP) => {

        console.log("item", itemP, itemP.partner._id)
        if (items.some((item) => item.partner._id != itemP.partner._id)) {
            messageError("Los productos deben pertenecer a la misma empresa")
            return;
        }
        let newItems = items;
        if (hasContentObject(items, itemP)) {
            let indexItem = newItems.findIndex(item => item.id == itemP.id)
            newItems[indexItem].incrementQuantity();
        } else {
            newItems.push(itemP)
        }

        localStorage.setItem("cart-items", JSON.stringify(encodedItems(newItems)));
        setItems(curr => [...newItems])
    }
    const updateCart = (items) => {
        localStorage.setItem("cart-items", JSON.stringify(encodedItems(items)))
        setItems(curr => [...items])

    }
    return <CartContext.Provider value={{ addToCart, items, updateCart }}>
        {props.children}
    </CartContext.Provider>
}