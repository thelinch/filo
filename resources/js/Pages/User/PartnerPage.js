import React from "react";
import PartnerOne from "../../components/Down/Partner/PartnerOne";
import { Grid, TablePagination } from "@material-ui/core";
import ProductList from "../../components/Down/Product/ProductList";
import { SearchContext } from "../../Contexts/SearchContext";
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import { ProductService } from "../../Services/ProductService"
import Product from "../../Domain/Product";
import PartnerDomain from "../../Domain/PartnerDomain";
class PartnerPage extends React.Component {
    static contextType = SearchContext

    constructor(props) {
        let { partner } = props.location.state
        partner = new PartnerDomain(partner._id, partner._description, partner._name, partner._dishes, partner._category, partner._address,
            partner._phone, partner._daysWork, partner._city, partner._photo);
        super(props)
        this.state = {
            partner,
            products: [],
            isLoadingProducts: true,
            page: 0,
            itemsPerPage: 2
        }

    }
    handleChangePage = (event, newPage) => {
        this.setState({ page: newPage })
    }
    handleChangeItemsPerPage = (event) => {
        this.setState({ itemsPerPage: +event.target.value, page: 0 })
    }
    async componentDidMount() {
        this.context.setFavorites([]);
        this.context.setCategories([<strong>No hay categorias</strong>]);
        let productsData = (await ProductService.getAllFindPartner(this.state.partner.id)).data
        let products = productsData.data;
        products = products.map((product) => new Product(product.id, product.name, product.votes, product.description, product.photo, product.price))
        this.setState({ products, isLoadingProducts: false })
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
                        <img src={product.photo} />
                    </div>
                    <div className="content">
                        <h6 className="title">{product.name}</h6>
                        <p className="description">{product.description}</p>

                    </div>
                    <button className="button primary" onClick={this.handleClickProduct(product.id)}>
                        <ShoppingCartIcon className="shoppin-icon" fontSize="small" />
                        <span className="price">
                            S./ {product.price}
                        </span>
                    </button>
                </div>

            ));
        }
        this.context.setFavorites(productsView);

    }

    handleClickProduct = (productId) => () => {
        console.log(productId)
    }
    render() {
        const { partner, products, itemsPerPage, page, isLoadingProducts } = this.state
        const productPaginate = products.slice(page * itemsPerPage, page * itemsPerPage + itemsPerPage);

        return (
            <React.Fragment>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <PartnerOne partner={partner} />
                    </Grid>
                    <ProductList products={productPaginate} isLoading={isLoadingProducts} handleClick={this.handleClickProduct} />

                    <Grid item xs={12}>
                        <TablePagination
                            rowsPerPageOptions={[2, 10, 20]}
                            component="div"
                            count={products.length}
                            rowsPerPage={itemsPerPage}
                            page={page}
                            onChangePage={this.handleChangePage}
                            onChangeRowsPerPage={this.handleChangeItemsPerPage}
                        />
                    </Grid>
                </Grid>
            </React.Fragment>
        )
    }

}
export default PartnerPage;