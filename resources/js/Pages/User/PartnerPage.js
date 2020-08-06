import React, { useState, useContext, useEffect } from "react";
import PartnerOne from "../../components/Down/Partner/PartnerOne";
import Grid from "@material-ui/core/Grid";
import TablePagination from "@material-ui/core/TablePagination";

import ProductList from "../../components/Down/Product/ProductList";
import { SearchContext } from "../../Contexts/SearchContext";
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import { ProductService } from "../../Services/ProductService"
import PartnerDomain from "../../Domain/PartnerDomain";
import ProductDomain from "../../Domain/ProductDomain";
import { CartContext } from "../../Contexts/CartContext";
import ImgPreview from "../../components/Img/ImgPreview";
import axios from "../../Config/axiosconfig";
const PartnerPage = (props) => {
    const searchContext = useContext(SearchContext);
    const cartContext = useContext(CartContext)
    console.log(cartContext);
    const panertLocation = props.location.state.partner
    const [partner, setPartner] = useState(new PartnerDomain(panertLocation._id, panertLocation._description, panertLocation._name, panertLocation._dishes, panertLocation._category, panertLocation._address,
        panertLocation._phone, panertLocation._daysWork, panertLocation._city, panertLocation._photo));
    const [products, setProducts] = useState([])
    const [isLoadingProducts, setIsLoadingProducts] = useState(true);
    const [page, setPage] = useState(0);
    const [itemsPerPage, setItemsPerPage] = useState(10);
    useEffect(() => {
        searchContext.setFavorites([]);
        searchContext.setCategories([<strong>No hay categorias</strong>]);
        async function fetchProductsFindPartner() {
            let productsData = (await ProductService.getAllFindPartner(partner.id)).data
            let products = productsData.data;
            products = products.map((product) => new ProductDomain(product.id, product.name, product.votes, product.description, product.photo, product.price))
            setProducts(products)
            setIsLoadingProducts(false);
            let productsView = [<strong>Actualmente no existe productos populares</strong>];
            let productsRank = products.sort((a, b) => {
                let result = 0;
                result = a.votes > b.votes ? -1 : 1;
                return result;
            }).filter((product) => product.votes > 0);

            if (productsRank.length > 0) {
                productsView = productsRank.slice(0, 3).map((product) => (
                    <div className="favorites-product">
                        <div className="photo">
                            <ImgPreview fileName={product.photo} directory={"images"} />
                        </div>
                        <div className="content">
                            <h6 className="title">{product.name}</h6>
                            <p className="description">{product.description}</p>

                        </div>
                        <button className="button primary" onClick={handleClickProduct(product.id)}>
                            <ShoppingCartIcon className="shoppin-icon" fontSize="small" />
                            <span className="price">
                                S./ {product.price}
                            </span>
                        </button>
                    </div>

                ));
            }
            searchContext.setFavorites(productsView);

        }
        fetchProductsFindPartner();

    }, [])
    const handleChangePage = (event, newPage) => {
        setPage(newPage)
    }
    const handleChangeItemsPerPage = (event) => {
        setItemsPerPage(+event.target.value)
        setPage(0);
    }
    const handleClickProduct = (productId) => () => {
        console.log(productId)
    }
    const productPaginate = products.slice(page * itemsPerPage, page * itemsPerPage + itemsPerPage);

    return (
        <React.Fragment>
            <Grid container spacing={2}>
                <Grid item xs={12}>
                    <PartnerOne partner={partner} />
                </Grid>
                <ProductList products={productPaginate} isLoading={isLoadingProducts} handleClick={handleClickProduct} />

                <Grid item xs={12}>
                    <TablePagination
                        rowsPerPageOptions={[10, 20, 50]}
                        component="div"
                        count={products.length}
                        rowsPerPage={itemsPerPage}
                        page={page}
                        onChangePage={handleChangePage}
                        onChangeRowsPerPage={handleChangeItemsPerPage}
                    />
                </Grid>
            </Grid>
        </React.Fragment>
    )
}
export default PartnerPage;