import React, { useContext } from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';
import Grid from "@material-ui/core/Grid";

import { getUser } from "../../Util/Util";
import * as Yup from "yup";
import { CartContext } from "../../Contexts/CartContext";
import Spinner from "../Spinner/Spinner";
const ShoppingCartForm = (props) => {
    const { items } = useContext(CartContext)
    let amountTotal = items.reduce((prev, current) => (prev + current.price * current.quantity), 0)
    let user = getUser();
    const validateSchema = Yup.object().shape({
        phone: Yup.string().length(9, "numero invalido").required("Requerido"),
        direction: Yup.string().required("requerido"),
        amountpayment: Yup.number().positive("Numero Positivo").test("amountMoreThan", "El monto debe ser mayor o igual al monto total ", function (value) {
            return value >= amountTotal
        }).required("requerido"),
    })
    return <Formik initialValues={{ phone: user.phone, direction: user.direction, amountpayment: "" }} onSubmit={props.onSubmit} validationSchema={validateSchema} enableReinitialize={true} mapPropsToValues={() => {
        return { phone: user.phone, direction: user.direction, amountpayment: "" };
    }
    }>
        {
            ({ values, handleChange, errors, touched, isSubmitting, setFieldValue, initialValues, resetForm }) => (
                <Form className="form" style={{ marginTop: "2rem" }}>
                    <Grid spacing={2} container={true}>
                        <Grid item xs={12}>
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
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="direction">Direccion</span>

                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field type="text" name="direction" placeholder="Direcion a donde se llevara el pedido" className={`field ${errors.direction && touched.direction ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="direction" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label" htmlFor="amountpayment">Monto a pagar</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="amountpayment" type="text" className={`field ${errors.amountpayment && touched.amountpayment ? "is-invalid" : ""}`} placeholder="Voy a pagar con (S./.50 S./ 100 ...)" />
                                        <ErrorMessage name="amountpayment" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="button-toolbar form-button-toolbar" style={{ float: "right" }}>
                                <button
                                    className="button flex-center button-primary"
                                    type="submit" disabled={isSubmitting}
                                >
                                    ¡Pedir Ahora !
                                    {
                                        isSubmitting && (<Spinner className="spinner primary" type="Circles" height="30px" width="30px" />)
                                    }
                                </button>
                            </div>
                        </Grid>
                    </Grid>
                </Form>
            )
        }
    </Formik >

}

export default ShoppingCartForm;