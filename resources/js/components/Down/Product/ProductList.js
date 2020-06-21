import React from "react"
import { Card, CardMedia, CardActionArea, CardContent, Grid, Typography, Box, CardActions, Button, CardHeader } from "@material-ui/core"
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
        <Grid item xs={12} md={4}>
            <Card className="product" onClick={handleClick(product.id)}>
                <CardHeader component={<img src={product.photo} />
                }>

                </CardHeader>
                <CardContent className="product-content">
                    <h6 className="title ">
                        {product.name}
                    </h6>
                    <p className="description">{product.description}</p>
                    <p className="price">
                        {product.price} <LocalOfferIcon />
                    </p>
                </CardContent>
                <CardActions>
                    <Button>
                        <ShoppingCartIcon />
                    </Button>
                </CardActions>
            </Card>
        </Grid >
    ));
    return (
        <Grid container spacing={2}>
            {products.lenght == 0 ? skeletonProduct : ProductsMap}
        </Grid>


    );

}

export default ProductList;