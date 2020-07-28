import React, { useState } from "react"
import ImgPreview from "../../Img/ImgPreview"
const CategoryItem = ({ name, id, url, selectCategory, handleClick }) => {
    return <div className={"category ".concat(selectCategory && selectCategory == id ? "select" : "")} key={id} onClick={handleClick(id)}>
        <div className="category-img">
            <ImgPreview fileName={url} directory={"images"} className="circle" />
        </div>

        <div className="category-name">
            <span>{name}</span>
        </div>
    </div>
};
export default CategoryItem;