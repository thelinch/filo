import PropTypes from "prop-types";
import React, { useState } from "react";
import CategoryItem from "./Category/CategoryItem";
import Skeleton from '@material-ui/lab/Skeleton';
import { Avatar } from "@material-ui/core";

const CategoriesList = ({ categories, handleClick }) => {
    const [selectcategory, setSelectcategory] = useState(-1);
    const selectItem = (idCategory) => () => {
        setSelectcategory(idCategory)
        handleClick(idCategory)
    }
    const categoriesRender = categories.map((category) => (
        <CategoryItem key={category.id} name={category.name} selectCategory={selectcategory} handleClick={selectItem} id={category.id} url={category.url} />
    ));
    const skeletonCategories = [1, 2, 3, 4].map((e) =>
        (
            <Skeleton key={e} width={60} height={60} variant="circle">
                <Avatar />

            </Skeleton>
        ));
    return (
        <div className="items">
            {
                categories.length == 0 ? skeletonCategories : categoriesRender
            }
        </div>
    )
}
CategoriesList.propTypes = {
    categories: PropTypes.arrayOf(PropTypes.shape({
        name: PropTypes.string,
        url: PropTypes.string
    }).isRequired).isRequired,
    handleClick: PropTypes.func
}
CategoriesList.defaultProps = {
    categories: []
}
export default CategoriesList;
