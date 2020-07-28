import React, { useState } from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';
import FileForm from "./Shared/FileForm"
import Grid from "@material-ui/core/Grid";
import Input from "@material-ui/core/Input";
import Spinner from "../Spinner/Spinner";
import WeekCalendar from "../Calendar/WeekCalendar"
import { transformDataWeekDayToLinealObject, hasContentObject, insertObjectToArray, updateObjetToArray } from "../../Util/Util";
import Chip from "@material-ui/core/Chip";
import { Box } from "@material-ui/core";
const BusinessForm = ({ BusinessSelect }) => {
    const BusinessSelectMap = BusinessSelect ? BusinessSelect : { id: 0, name: "", price: "", photo: [{}] }
    const [selectdays, setSelectdays] = useState([])
    const onSubmit = (values) => {
        console.log(values)

    }
    const onSelectinterval = (values) => {
        let arrayMapValues = transformDataWeekDayToLinealObject(values);
        for (let i = 0; i < arrayMapValues.length; i++) {
            if (hasContentObject(selectdays, arrayMapValues[i])) {
                updateObjetToArray(selectdays, arrayMapValues[i])
            } else {
                selectdays.push(arrayMapValues[i])
            }
        }
        setSelectdays(cur => [...selectdays])


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
                            <h3 className="text-center">Como quieres que te conoscan?</h3>
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
                                <span className="form-group-label">Telefono:</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field placeholder="Numero de telefono" name="phone" type="text" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Cosas que vendas,dedicacion,etc" />
                                        <ErrorMessage name="price" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12} md={6}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Email:</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="email" type="text" placeholder="correo electronico" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="email" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Direccion:</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="direction" type="text" placeholder="Direccion" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="direction" component="div" className="form-group-error" />
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
                            <Grid container>
                                <Grid item xs={12}>
                                    {
                                        selectdays.length > 0 && <Box display="flex" alignItems="center" width="100%" justifyContent="center" >
                                            {selectdays.map(selectday => (
                                                <Chip label={
                                                    <React.Fragment key={selectday.id}>
                                                        <span>{selectday.day}</span>
                                                        <strong>{selectday.inithour}-{selectday.endhour}</strong>
                                                    </React.Fragment>
                                                } style={{ margin: ".5em" }} />
                                            ))}
                                        </Box>
                                    }
                                </Grid>
                                <Grid item xs={12}>
                                    <div className="form-group-horizontal">
                                        <span className="form-group-label">Dias de atencion</span>

                                        <div className="form-group-field">
                                            <div className="form-group-input-wrap">
                                                <Field name="price" component={WeekCalendar} onIntervalSelect={onSelectinterval} weekdays={[{ id: "1", day: "Lunes" }, { id: "2", day: "Martes" }, { id: "3", day: "Miercoles" }, { id: "4", day: "Jueves" }, { id: "5", day: "Viernes" }, { id: "6", day: "Sabado" }, { id: "7", day: "Domingo" }]} className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Cosas que vendas,dedicacion,etc" />
                                                <ErrorMessage name="price" component="div" className="form-group-error" />
                                            </div>
                                        </div>
                                    </div>

                                </Grid>
                            </Grid>
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