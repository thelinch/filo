import React from "react";
import PartnerOne from "../../components/Down/Partner/PartnerOne";
import { Grid } from "@material-ui/core";
import ProductList from "../../components/Down/Product/ProductList";
import { SearchContext } from "../../Contexts/SearchContext";
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import { ProductService } from "../../Services/ProductService"
import Product from "../../Domain/Product";
class PartnerPage extends React.Component {
    static contextType = SearchContext

    constructor(props) {
        console.log(props)
        const { partner } = props.location.state
        super(props)
        this.state = {
            partner,
            products: []
        }

    }
    async componentDidMount() {
        this.context.setFavorites([]);
        this.context.setCategories([<strong>No hay categorias</strong>]);
        let productsData = (await ProductService.getAllFindPartner(this.state.partner.id)).data
        let products = productsData.data;
        products = products.map((product) => new Product(product.id, product.name, product.votes, product.description, product.photo, product.price))
        this.setState({ products })
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
        const { partner, products } = this.state
        return (
            <React.Fragment>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <PartnerOne partner={partner} />
                    </Grid>
                    <Grid item xs={12}>
                        <ProductList products={products} handleClick={this.handleClickProduct} />
                    </Grid>
                </Grid>
            </React.Fragment>
        )
    }

}
export default PartnerPage;