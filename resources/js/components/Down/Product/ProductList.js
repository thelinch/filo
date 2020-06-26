import React from "react"
import { Grid, Typography, Box } from "@material-ui/core"
import Skeleton from "@material-ui/lab/Skeleton";
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import LocalOfferIcon from '@material-ui/icons/LocalOffer';
import FavoriteIcon from '@material-ui/icons/Favorite';
const ProductList = ({ products, handleClick }) => {
    const skeletonProduct = [1, 2, 3, 4].map(() => (
        <Grid item xs={12} md={4}>
            <Box width="100%" height={150}>
                <Skeleton variant="rect" height="100%" />
            </Box>
        </Grid>

    ));
    const ProductsMap = products.map((product) => (
        <Grid item xs={12} md={3}>
            <div className="product">
                <div className="product-photo circle" >
                    <img src={product.photo} className="circle" />
                    <div className="heart">
                        <strong>{product.votes}</strong>
                        <FavoriteIcon className="icon" />
                    </div>
                </div>
                <div className="product-content">
                    <h5 className="title text-center">{product.name}</h5>
                    <p className="description text-center">{product.description}</p>
                </div>
                <button className="button primary full-width">
                    <ShoppingCartIcon className="shoppin-icon" />
                    <span className="price">
                        S./ {product.price}
                    </span>
                </button>
            </div>
        </Grid >
    ));
    return (
        <Grid container spacing={2}>
            {products.length == 0 ? skeletonProduct : ProductsMap}
        </Grid>


    );

}

export default ProductList;