import React, { useState } from "react"
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
import { messageSuccess } from "../../Util/Swal";
import SelectField from "./Shared/SelectField";

const validateSchema = Yup.object().shape({
    name: Yup.string().required("Requerido"),
    email: Yup.string().email("ingrese un email valido").required("requerido"),
    phone: Yup.string().length(9, "debe tener 9 digitos").required("requerido"),
    direction: Yup.string().required("Direccion requerida para el delivery"),
    password: Yup.string().required("requerido")
})
const RegisterForm = (props) => {
    const [cities, setCities] = useState([{ label: "Yanahuanca", value: 2 }, { label: "Tingo Maria", value: 1 }])
    const onSubmit = async (values) => {
        console.log(values)
        values.id = generateUuid();
        await CredentialService.save(values)
        messageSuccess("Se registro correctamente, Inicie sesion");

    }


    return <Formik initialValues={{ name: "", phone: "", email: "", direction: "", password: "", city: { id: 0 } }} validationSchema={validateSchema} enableReinitialize={true} onSubmit={onSubmit} mapPropsToValues={() => {
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
                        <Grid item xs={12} md={6}>
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
                        <Grid item xs={12} md={6}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="direction">Ciudad</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="city.id" component={SelectField} options={cities} className={`field ${errors.city && touched.city ? "is-invalid" : ""}`} placeholder="Ciudad" />
                                        <ErrorMessage name="city" component="div" className="form-group-error" />
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
                                    className="button flex-center button-primary flex  aling-center align-space-beetwen"
                                    type="submit"
                                >
                                    Registrate
                                    {isSubmitting && (<Spinner className="spinner primary" type="Circles" height="40px" width="40px" />)}
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