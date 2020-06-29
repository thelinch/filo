import React, { useState } from "react"
const CategoryItem = ({ name, id, url, selectCategory, handleClick }) => {
    return <div className={"category ".concat(selectCategory && selectCategory == id ? "select" : "")} key={id} onClick={handleClick(id)}>
        <div className="category-img">
            <img src={url} />
        </div>

        <div className="category-name">
            <span>{name}</span>
        </div>
    </div>
};
export default CategoryItem;