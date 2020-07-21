import React from "react"
import ProductForm from "../../components/Form/ProductForm";
import { SearchContext } from "../../Contexts/SearchContext";



class ProductPage extends React.Component {
    static contextType = SearchContext

    constructor(props) {
        super(props)
    }
    componentDidMount() {
        this.context.setFavorites([]);
        let productsView = [<strong>Actualmente no existe productos populares</strong>];
        this.context.setFavorites(productsView);

    }

    render() {
        return <ProductForm />
    }
}


export default ProductPage;