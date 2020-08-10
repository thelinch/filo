import React from "react"
import Paper from "@material-ui/core/Paper"
import ImgPreview from "../Img/ImgPreview";

const TransactionItems = ({ items }) => {
    const itemsRender = items.map((item) => (<Paper className="item" key={item.id}>
        <div className="item-img">
            <ImgPreview widthSpinner="50%" style={{ height: "100%" }} fileName={item.product.photo} directory="images" />
        </div>
        <div className="item-detail">
            <p className="item-detail-name">{item.product.name}</p>
            <span className="item-detail-price">S./{item.product.price}</span>
            <strong className="item-detail-quantity">{item.quantity}</strong>

        </div>
    </Paper>));
    return itemsRender

}

export default TransactionItems;