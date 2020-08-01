import React from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';
import Grid from "@material-ui/core/Grid";
import Input from "@material-ui/core/Input";
import PropTypes from 'prop-types';
import Spinner from "../Spinner/Spinner";
import * as Yup from "yup";
import { CredentialService } from "../../Services/CredentialService";
import { generateUuid } from "../../Util/Util";
const validateSchema = Yup.object().shape({
    name: Yup.string().required("Requerido"),
    email: Yup.string().email("ingrese un email valido").required("requerido"),
    phone: Yup.string().required("requerido"),
    direction: Yup.string().required("Direccion requerida para el delivery"),
    password: Yup.string().required("requerido")
})
const RegisterForm = (props) => {

    const onSubmit = async (values) => {
        values.id = generateUuid();
        console.log(values)
        await CredentialService.save(values)
    }

    return <Formik initialValues={{ name: "", phone: "", email: "", direction: "", password: "" }} validationSchema={validateSchema} enableReinitialize={true} onSubmit={onSubmit} mapPropsToValues={() => {
        return { name: "", phone: "", email: "", direction: "", password: "" };
    }
    }>
        {
            ({ values, handleChange, errors, touched, isSubmitting, setFieldValue, initialValues, resetForm }) => (
                <Form className="form">
                    <Grid spacing={2} container={true}>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="name">Nombre</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field type="text" name="name" placeholder="Nombre" className={`field ${errors.name && touched.name ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="name" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12} md={6}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="phone">Telefono</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field type="text" name="phone" placeholder="Telefono" className={`field ${errors.phone && touched.phone ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="phone" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>

                        <Grid item xs={12} md={6}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="email">email</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="email" type="text" className={`field ${errors.email && touched.email ? "is-invalid" : ""}`} placeholder="Correo electronico" />
                                        <ErrorMessage name="email" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="direction">Direccion</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="direction" className={`field ${errors.direction && touched.direction ? "is-invalid" : ""}`} placeholder="Ejem. Jiron tupac" />
                                        <ErrorMessage name="direction" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="passoword">Contraseña</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="password" type="password" className={`field ${errors.password && touched.password ? "is-invalid" : ""}`} placeholder="clave" />
                                        <ErrorMessage name="password" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="button-toolbar form-button-toolbar" style={{ float: "right" }}>
                                <button
                                    className="button flex-center button-primary"
                                    type="submit"
                                >
                                    Registrate
                                    {isSubmitting && (<Spinner />)}
                                </button>
                            </div>
                        </Grid>
                    </Grid>
                </Form>
            )
        }
    </Formik >
}

export default RegisterForm;