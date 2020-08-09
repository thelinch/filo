import React, { useContext } from "react";

import { CartContext } from "../../Contexts/CartContext";
import ListItemShoppingCart from "./ListItemShoppingCart";
import { hasContentObject, deleteElementOfArray } from "../../Util/Util"
const ShoppingCart = (props) => {
    const { items, updateCart } = useContext(CartContext);

    const onDelete = (itemParameter) => () => {
        itemParameter.delete();
        if (hasContentObject(items, itemParameter)) {
            deleteElementOfArray(items, itemParameter.id)
        }
        updateCart(items)

    }
    const onChangeInput = (itemParameter, event) => {
        items.find(item => item.id == itemParameter.id).quantity = parseInt(event.target.value)
        updateCart(items);
    }
    const total = items.reduce((prev, current) => (prev + current.price * current.quantity), 0)

    return <React.Fragment>
        <div className="content">
            {
                items.length == 0 ? <p>No hay elementos</p> :
                    <React.Fragment>
                        <table className="table">
                            <thead className="head">
                                <tr className="tr tr_first">
                                    <th>Imagen</th>
                                    <th>Denominacion</th>
                                    <th>Cant.</th>
                                    <th>P.U</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    <ListItemShoppingCart itemsP={items} onDelete={onDelete} onChangeInput={onChangeInput} />
                                }

                            </tbody>
                        </table>
                        <strong style={{ display: "block", textAlign: "end", width: "100%" }}>
                            Total S./ {total}
                        </strong>

                    </React.Fragment>

            }

        </div>
    </React.Fragment>
}

export default ShoppingCart;