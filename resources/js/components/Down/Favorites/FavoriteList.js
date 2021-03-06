
import React from "react";
import { Grid, Box } from "@material-ui/core";
import Skeleton from "@material-ui/lab/Skeleton";
import PropTypes from "prop-types"

const FavoriteList = ({ favorites, isLoading }) => {
    const skeletonFavoriteList = [1, 2, 3, 4, 5, 6].map((e) => (
        <Grid item xs={12} md={6} key={e}>
            <Box width="100%" height={50}>
                <Skeleton variant="rect" height="100%" />
            </Box>
        </Grid>

    ));
    const FavoriteList = favorites.map((favorite, index) => (
        <Grid item xs={12} md={6}>
            <div className="favorite" key={1000 + index} >
                {favorite}
            </div>

        </Grid>
    ))
    return (
        favorites.length == 0 ? skeletonFavoriteList : FavoriteList
    );
}
FavoriteList.propTypes = {
    isLoading: PropTypes.bool.isRequired,
    favorites: PropTypes.array.isRequired
}
FavoriteList.defaultProps = {
    isLoading: true
}
export default FavoriteList;