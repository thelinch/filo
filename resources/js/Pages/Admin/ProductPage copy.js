import React, { useState, useEffect, useContext } from "react"
import ProductForm from "../../components/Form/ProductForm";
import { SearchContext } from "../../Contexts/SearchContext";
import Grid from "@material-ui/core/Grid";
import DataTable from "../../components/DataTable"
import { ProductService } from "../../Services/ProductService";
import Delete from '@material-ui/icons/Delete';
import Edit from '@material-ui/icons/Edit';
import Modal from "../../components/Modal/Modal";
import { removeObjectOfArray, insertObjectToArray, hasContentObject, updateObjetToArray, deleteElementOfArray } from "../../Util/Util";

const ProductPage = (props) => {
    const searchContext = useContext(SearchContext)
    const [products, setProducts] = useState([])
    const [productSelect, setProductSelect] = useState(null);
    const [formProductModal, setFormProductModal] = useState(false)
    const columns = [{
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
                    <button className="button button-danger" onClick={handelRemoveProduct(product)} ><Delete /> </button>
                    <button className="button button-warning" onClick={handleEditProduct(product)} ><Edit /> </button>
                </div>
            </div>
        )
    }
    ]
    useEffect(() => {
        searchContext.setFavorites([]);
        let productsView = [<strong>Actualmente no existe productos populares</strong>];
        searchContext.setFavorites(productsView);
        async function getProductsApi() {

            let productsData = (await ProductService.getAllFindPartner()).data
            setProducts(productsData.data)
        }
        getProductsApi();
    }, [])
    const handelRemoveProduct = (product) => async () => {
        (await ProductService.deleteProduct(product.id))
        /* this.setState({ products: removeObjectOfArray(this.state.products, product) }) */
        let productsCopy = products;

        deleteElementOfArray(productsCopy, product.id)
        console.log("products", productsCopy)
        setProducts(productsCopy)
    }
    const handleEditProduct = (product) => () => {
        /*  this.setState({ productSelect: product, formProductModal: true }) */
        setProductSelect(product);
        setFormProductModal(true);
    }
    const handleCloseModal = () => {
        /* this.setState({ formProductModal: false }) */
        setFormProductModal(false);
    }
    const handleNewProduct = () => {
        setProductSelect(null);
        setFormProductModal(true)
        /* this.setState({ formProductModal: true, productSelect: null }) */

    }
    const handleSubmitSuccess = (product) => {
        let productsCopy = products
        if (!hasContentObject(productsCopy, product)) {
            insertObjectToArray(productsCopy, product)
        } else {
            updateObjetToArray(productsCopy, product)
        }
        console.log(productsCopy)
        /*  this.setState({ products: productsCopy }) */
        setProducts(curr => [...productsCopy])
        /* console.log(this.state.products) */
        handleCloseModal();

    }
    return (<Grid container spacing={2}>
        <Grid item xs={12}>
            <button className="button button-primary" onClick={handleNewProduct} >
                Nuevo producto
            </button>
        </Grid>
        <Grid item xs={12}>
            <DataTable responsive={true} exportToCSV={true} data={products} columns={columns} />
        </Grid>
        <Modal color="primary" title="Formulario de producto" header show={formProductModal} onClose={handleCloseModal}>
            <ProductForm onSubmitSuccess={handleSubmitSuccess} productSelect={productSelect} />
        </Modal>
    </Grid>)
}

export default ProductPage;