import React, { useState } from "react"
import ImgPreview from "../Img/ImgPreview"
const ListItemShoppingCart = ({ itemsP }) => {
    console.log()
    const [items, setItems] = useState(itemsP);
    const handleChange = (itemParameter, event) => {
        console.log(itemParameter, event.target.value)
        items.find(item => item.id == itemParameter.id).quantity = event.target.value
        setItems(curr => [...items])

    }
    return items.map((item) => (<tr key={item.id} className="tr">
        <td style={{ width: "20%" }}>
            <ImgPreview fileName={item.photo} directory="images" />
        </td>
        <td>
            {item.name}
        </td>
        <td>
            <input style={{ width: "50%" }} value={item.quantity} type="number" onChange={(event) => { handleChange(item, event) }} />
        </td>
        <td>
            S./ {item.price}
        </td>
        <td>
            S./ {item.quantity * item.price}
        </td>
    </tr>))


}
export default ListItemShoppingCart;