import React from "react"
import ProductForm from "../../components/Form/ProductForm";
import { SearchContext } from "../../Contexts/SearchContext";
import Grid from "@material-ui/core/Grid";
import DataTable from "../../components/DataTable"
import { ProductService } from "../../Services/ProductService";
import Delete from '@material-ui/icons/Delete';
import Edit from '@material-ui/icons/Edit';
import Modal from "../../components/Modal/Modal";
import { removeObjectOfArray, insertObjectToArray, hasContentObject } from "../../Util/Util";

class ProductPage extends React.Component {
    static contextType = SearchContext
    columns = [{
        title: "N°",
        render: (value, record, index) => (index + 1)
    },
    { title: "Denominacion", dataIndex: "name" },
    { title: "Precio", dataIndex: "price" },
    { title: "Descripcion", dataIndex: "description" },
    {
        title: "Acciones",
        render: (product, record, index) => (
            <div className="button-toolbar" style={{ float: "right" }}>
                <div className="button-group button-group--icons" >
                    <button className="button button-danger" onClick={this.handelRemoveProduct(product)} ><Delete /> </button>
                    <button className="button button-warning" onClick={this.handleEditProduct(product)} ><Edit /> </button>
                </div>
            </div>
        )
    }
    ]
    constructor(props) {
        super(props)
        this.state = {
            products: [],
            productSelect: null,
            formProductModal: false
        }

    }
    handelRemoveProduct = (product) => async () => {
        (await ProductService.deleteProduct(product.id))
        this.setState({ products: removeObjectOfArray(this.state.products, product) })
    }
    handleEditProduct = (product) => () => {
        this.setState({ productSelect: product, formProductModal: true })
    }
    async componentDidMount() {
        this.context.setFavorites([]);
        let productsView = [<strong>Actualmente no existe productos populares</strong>];
        this.context.setFavorites(productsView);
        let productsData = (await ProductService.getAllFindPartner("dddw")).data
        this.setState({ products: productsData.data })
    }
    handleCloseModal = () => {
        this.setState({ formProductModal: false })
    }
    handleNewProduct = () => {
        this.setState({ formProductModal: true, productSelect: null })

    }
    handleSubmitSuccess = (product) => {
        let productsCopy = this.state.products
        if (!hasContentObject(productsCopy, product)) {
            insertObjectToArray(productsCopy, product)
        } else {
            updateObjetToArray(productsCopy, product)
        }
        this.setState({ products: productsCopy })
        this.handleCloseModal();
    }
    render() {
        const { products, productSelect, formProductModal } = this.state
        return (<Grid container spacing={2}>
            <Grid item xs={12}>
                <button className="button button-primary" onClick={this.handleNewProduct} >
                    Nuevo producto
                </button>
            </Grid>
            <Grid item xs={12}>
                <DataTable responsive={true} exportToCSV={true} data={products} columns={this.columns} />
            </Grid>
            <Modal color="primary" title="Formulario de producto" header show={formProductModal} onClose={this.handleCloseModal}>
                <ProductForm onSubmitSuccess={this.handleSubmitSuccess} productSelect={productSelect} />
            </Modal>
        </Grid>)

    }
}


export default ProductPage;