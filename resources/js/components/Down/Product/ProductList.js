import React from "react"
import Grid from "@material-ui/core/Grid"
import Typography from "@material-ui/core/Typography"
import Box from "@material-ui/core/Box"

import Skeleton from "@material-ui/lab/Skeleton";
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import ProductFavorite from "../../Product/ProductFavorite";
import ImgPreview from "../../Img/ImgPreview";
const ProductList = ({ products, handleClick, isLoading }) => {
    const notProducts = (<div width="100%" className="not-items" display="flex" justifyContent="center">
        <strong className="message">Sin productos</strong>
    </div>);
    const skeletonProduct = [1, 2, 3, 4, 5, 6].map((e) => (
        <Grid item xs={12} md={4} key={e}>
            <Box width="100%" height={150}>
                <Skeleton variant="rect" height="100%" />
            </Box>
        </Grid>

    ));
    const ProductsMap = products.map((product) => (
        <Grid item xs={12} md={3} key={product.id + 1000}>
            <div className="product" key={product.id}>
                <div className="product-photo circle" >
                    <ImgPreview fileName={product.photo} directory={"images"} className="circle" />
                    <div className="labels">
                        <ProductFavorite product={product} />
                    </div>
                </div>
                <div className="product-content">
                    <h5 className="title text-center">{product.name}</h5>
                    <p className="description text-center">{product.description}</p>
                </div>
                <button className="button primary full-width" onClick={handleClick(product.id)}>
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
            {isLoading ? skeletonProduct : products.length == 0 ? notProducts : ProductsMap}

        </Grid>


    );

}
export default ProductList;