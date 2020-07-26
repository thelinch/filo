import React from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';
import FileForm from "./Shared/FileForm"
import Grid from "@material-ui/core/Grid";
import Input from "@material-ui/core/Input";
import Spinner from "../Spinner/Spinner";
const BusinessForm = ({ BusinessSelect }) => {
    const BusinessSelectMap = BusinessSelect ? BusinessSelect : { id: 0, name: "", price: "", photo: [{ source: "polleria.jpg", options: { type: "local" } }] }
    const onSubmit = (values) => {
        console.log(values)

    }
    return <Formik initialValues={BusinessSelectMap} enableReinitialize={true} onSubmit={onSubmit} mapPropsToValues={() => {
        return BusinessSelectMap;
    }}>
        {
            ({ values, handleChange, errors, touched, isSubmitting, setFieldValue, initialValues, resetForm }) => (
                <Form className="form">
                    <Grid spacing={2} container={true}>
                        <Input name="id" type="hidden" value={values.id} />
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="name">Como quieres que te conoscan?</span>
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
                                <span className="form-group-label">Descripcion</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="price" type="text" as="textarea" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Cosas que vendas,dedicacion,etc" />
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
                                        <Field name="photo" component={FileForm} messageUser="Foto de tu empresa" filesParameter={values.photo} directory="images" className={`field ${errors.category && touched.category ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="photo" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="button-toolbar form-button-toolbar">
                                <button
                                    className="button flex-center"
                                    disabled={isSubmitting}
                                    type="submit"
                                >
                                    {values.id > 0 ? "Editar" : "Guardar"}
                                    {isSubmitting && <Spinner type="Circles" />}
                                </button>
                                <button
                                    className="button"
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
    </Formik>

}


export default BusinessForm;