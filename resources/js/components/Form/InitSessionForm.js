import React from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';
import Grid from "@material-ui/core/Grid";
import Input from "@material-ui/core/Input";
import PropTypes from 'prop-types';
import Spinner from "../Spinner/Spinner";
import * as Yup from "yup";
import cookie from 'react-cookies';
import { connect } from 'react-redux';
import { CredentialService } from "../../Services/CredentialService";
import { login } from "../../redux/actions/authActions";
import { setUser } from "../../Util/Util";
import { navigate } from "@reach/router"
const validateSchema = Yup.object().shape({
    email: Yup.string().email("ingrese un email valido").required("requerido"),
    password: Yup.string().required("requerido")
})

const InitSession = (props) => {
    const onSubmit = async (values) => {
        let token = (await CredentialService.login(values)).data
        cookie.remove("token");
        cookie.save("token", token.access_token);
        let userData = (await CredentialService.me()).data
        setUser(userData);
        props.dispatch(login());
        navigate(props.redirectUrl ?? "/");

    }

    return <Formik initialValues={{ email: "", password: "" }} validationSchema={validateSchema} enableReinitialize={true} onSubmit={onSubmit} mapPropsToValues={() => {
        return { email: "", password: "" };
    }
    }>
        {
            ({ values, handleChange, errors, touched, isSubmitting, setFieldValue, initialValues, resetForm }) => (
                <Form className="form">
                    <Grid spacing={2} container={true}>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="email">Email</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field type="text" name="email" placeholder="Correo electronico" className={`field ${errors.email && touched.email ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="email" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="password">Contraseña</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field type="password" name="password" placeholder="Contraseña" className={`field ${errors.password && touched.password ? "is-invalid" : ""}`} />
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
                                    Ingresar
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
export default connect()(InitSession);