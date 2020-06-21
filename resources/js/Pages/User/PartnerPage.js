import React from "react";
import PartnerOne from "../../components/Down/Partner/PartnerOne";
import { Grid } from "@material-ui/core";
import ProductList from "../../components/Down/Product/ProductList";

class PartnerPage extends React.Component {

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

        setTimeout(() => {
            let { products } = this.state
            products.push({ id: 1, name: "Wdwdw", price: 12, description: "efefefef efe efef", votes: 2, photo: "/img/polleria.jpg" })
            products.push({ id: 2, name: "Wdwdw", price: 12, description: "efefefef efe efef", votes: 2, photo: "/img/polleria.jpg" })
            products.push({ id: 3, name: "Wdwdw", price: 12, description: "efefefef efe efef", votes: 2, photo: "/img/polleria.jpg" })
            products.push({ id: 4, name: "Wdwdw", price: 12, description: "efefefef efe efef", votes: 2, photo: "/img/polleria.jpg" })
            products.push({ id: 5, name: "Wdwdw", price: 12, description: "efefefef efe efef", votes: 2, photo: "/img/polleria.jpg" })
            this.setState({ products })
        }, 3000)
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