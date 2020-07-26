import React from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';
import FileForm from "./Shared/FileForm"
import Grid from "@material-ui/core/Grid";
import Input from "@material-ui/core/Input";
import PropTypes from 'prop-types';
import Spinner from "../Spinner/Spinner";
import productUtil from "../../Util/Product/Util";
import { generateUuid } from "../../Util/Util";
import { ProductService } from "../../Services/ProductService"
import { FileService } from "../../Services/FileService";
const ProductForm = ({ productSelect, onSubmitSuccess }) => {
    const productSelectMap = productSelect ? { ...productSelect, photo: [productUtil.transformPhotoSaved(productSelect.photo)] } : {
        id: 0, name: "", price: "", description: "", photo: [{}]
    }
    const onSubmit = async (values) => {
        let url = "";
        console.log("values", values)
        if (Object.keys(values.photo[0]).length > 0 && values.photo[0].lastModified) {
            let formData = new FormData();
            formData.append("files[]", values.photo[0]);
            url = ((await FileService.save(formData, "images")).data)[0].url;
            values.photo = url;
        }
        if (values.id == 0) {
            values = { ...values, id: generateUuid(), partnerId: "dddw" };
            (await ProductService.save(values))
        } else {
            console.log("entro al else", values)
            await ProductService.update(values)
        }
        onSubmitSuccess(values)
    }
    const onRemoveFile = (productId) => {
        if (productId != 0) {
            ProductService.deletePhotoById(productId);
        }
    }
    return <Formik initialValues={productSelectMap} enableReinitialize={true} onSubmit={onSubmit} mapPropsToValues={() => {
        return productSelectMap;
    }
    }>
        {
            ({ values, handleChange, errors, touched, isSubmitting, setFieldValue, initialValues, resetForm }) => (
                <Form className="form">
                    <Grid spacing={2} container={true}>
                        <Input name="id" type="hidden" value={values.id} />
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="name">Denominacion</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field type="text" name="name" placeholder="Nombre" className={`field ${errors.name && touched.name ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="name" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="name">Descripcion</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field type="text" name="description" as="textarea" placeholder="Color,cremas,tallas,formas,etc." className={`field ${errors.name && touched.name ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="description" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>

                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Precio</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="price" type="text" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Precio del producto" />
                                        <ErrorMessage name="price" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Miniatura</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="photo" component={FileForm} onRemoveFileObject={onRemoveFile} filesParameter={values.photo} directory="images" className={`field ${errors.category && touched.category ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="photo" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="button-toolbar form-button-toolbar">
                                <button
                                    className="button flex-center button-primary"

                                    type="submit"
                                >
                                    {values.id != 0 ? "Editar" : "Guardar"}
                                    {isSubmitting && <Spinner type="Circles" />}
                                </button>
                                <button
                                    className="button button-primary"
                                    type="button"
                                >
                                    Cancelar
                                        </button>
                            </div>
                        </Grid>
                    </Grid>
                </Form>
            )
        }
    </Formik >

}

ProductForm.propTypes = {
    onSubmitSuccess: PropTypes.func.isRequired,
    productSelect: PropTypes.object
}
ProductForm.defaultProps = {
    productSelect: null
}
export default ProductForm;