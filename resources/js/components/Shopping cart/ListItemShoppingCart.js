import React, { useState } from "react"
import ImgPreview from "../Img/ImgPreview"
import HighlightOffIcon from '@material-ui/icons/HighlightOff';
const ListItemShoppingCart = ({ itemsP, onChangeInput, onDelete }) => {
    return itemsP.map((item) => (<tr key={item.id} className="tr item">
        <td style={{ width: "20%" }}>
            <ImgPreview fileName={item.photo} directory="images" />
        </td>
        <td>
            {item.name}
        </td>
        <td>
            <input style={{ width: "50%" }} value={item.quantity} type="number" min="1" onChange={(event) => { onChangeInput(item, event) }} />
        </td>
        <td>
            S./ {item.price}
        </td>
        <td>
            S./ {item.quantity * item.price}
        </td>
        <HighlightOffIcon className="delete " style={{ cursor: "pointer" }} onClick={onDelete(item)} />
    </tr>))


}
export default ListItemShoppingCart;