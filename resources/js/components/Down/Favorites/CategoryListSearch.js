
import React from "react";
import { Grid, Box } from "@material-ui/core";
import Skeleton from "@material-ui/lab/Skeleton";
import PropTypes from "prop-types"

const CategoryListSearch = ({ categories, isLoading }) => {
    const skeletonCategoryList = [1, 2, 3, 4, 5, 6].map((e) => (
        <Grid item xs={12} md={6} key={e}>
            <Box width="100%" height={50}>
                <Skeleton variant="rect" height="100%" />
            </Box>
        </Grid>

    ));

    return (
        categories.length == 0 ? skeletonCategoryList : FavoriteList
    );
}
CategoryListSearch.propTypes = {
    isLoading: PropTypes.bool.isRequired,
    categories: PropTypes.array.isRequired
}
CategoryListSearch.defaultProps = {
    isLoading: true
}
export default CategoryListSearch;