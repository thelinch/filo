import React, { useState, useEffect } from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';
import FileForm from "./Shared/FileForm"
import Grid from "@material-ui/core/Grid";
import Input from "@material-ui/core/Input";
import Spinner from "../Spinner/Spinner";
import WeekCalendar from "../Calendar/WeekCalendar"
import { transformDataWeekDayToLinealObject, hasSendFileToServer, insertObjectToArray, updateDayToArray, hasContentDayToArray, updateObjetToArray, generateUuid } from "../../Util/Util";
import Chip from "@material-ui/core/Chip";
import Box from "@material-ui/core/Box";
import Select from "./Shared/Select";
import { CategoryService } from "../../Services/CategoryService"
import { FileService } from "../../Services/FileService";
import { BusinessService } from "../../Services/BusinessService"
const BusinessForm = ({ BusinessSelect }) => {
    const BusinessSelectMap = BusinessSelect ? BusinessSelect : { id: 0, name: "", description: "", email: "", category: {}, city: {}, address: "", phone: "", amountdelivery: "", photo: [{}], daysworks: [] }
    const [selectdays, setSelectdays] = useState([])
    const [categories, setCategories] = useState([])
    const [cities, setCities] = useState([{ label: "Yanahuanca", value: { id: 2, name: "Yanahuanca" } }, { label: "Tingo Maria", value: { id: 1, name: "Tingo Maria" } }])
    const onSubmit = async (values) => {
        console.log("values", values)
        let url = ""
        if (hasSendFileToServer(values.photo[0])) {
            let formData = new FormData();
            formData.append("files[]", values.photo[0]);
            url = ((await FileService.save(formData, "images")).data)[0].url;
            values.photo = url;
        }
        if (values.id == 0) {
            values.id = generateUuid();
            values.daysworks = values.daysworks.map(worday => ({ id: generateUuid(), ...worday }))
            console.log("values map", values)
                (await BusinessService.save(values))
        } else {
            if (url == "") {
                values.photo = productSelectMap.photo[0].source;
            }
        }
    }
    useEffect(() => {
        async function fetchCategoriesApi() {
            let dataCategories = (await CategoryService.getAll()).data
            dataCategories = dataCategories.map(category => ({ value: category, label: category.name }))
            setCategories(dataCategories)
        }
        fetchCategoriesApi();

    }, [])
    const handleDeleteHour = (hour) => () => {
        console.log(hour)
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
                                        <Field placeholder="Numero de telefono" name="phone" type="text" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="phone" component="div" className="form-group-error" />
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
                                        <Field name="address" type="text" placeholder="Direccion" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="address" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Descripcion</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="description" type="text" as="textarea" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Cosas que vendas,dedicacion,etc" />
                                        <ErrorMessage name="description" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12} md={6}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Categoria</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="category" component={Select} options={categories} className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Categoria al que pertenece" />
                                        <ErrorMessage name="category" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12} md={6}>
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Ciudad</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="city" component={Select} options={cities} className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Categoria al que pertenece" />
                                        <ErrorMessage name="city" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12} >
                            <div className="form-group-horizontal">
                                <span className="form-group-label">Monto adicional por delivery</span>
                                <div className="form-group-field">
                                    <div className="form-group-input-wrap">
                                        <Field name="amountdelivery" type="text" className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Costo adicional por el delivery" />
                                        <ErrorMessage name="amountdelivery" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <Grid container>
                                <Grid item xs={12}>
                                    {
                                        <Box display="flex" alignItems="center" width="100%" justifyContent="center" flexWrap="wrap" >
                                            {values.daysworks.map(selectday => (
                                                <Chip label={
                                                    <React.Fragment key={selectday.day.id}>
                                                        <span>{selectday.day.name}</span>
                                                        <strong style={{ padding: ".3rem" }}>{selectday.startime}-{selectday.endtime}</strong>
                                                    </React.Fragment>
                                                } style={{ margin: ".5em" }} onDelete={handleDeleteHour(selectday)} />
                                            ))}
                                        </Box>
                                    }
                                </Grid>
                                <Grid item xs={12}>
                                    <div className="form-group-horizontal">
                                        <span className="form-group-label">Dias de atencion</span>

                                        <div className="form-group-field">
                                            <div className="form-group-input-wrap">
                                                <Field name="daysworks" component={WeekCalendar} onIntervalSelect={(valuesSelectinterval) => {
                                                    let workDaysForm = values.daysworks;
                                                    let arrayMapValues = transformDataWeekDayToLinealObject(valuesSelectinterval);
                                                    for (let i = 0; i < arrayMapValues.length; i++) {
                                                        if (hasContentDayToArray(workDaysForm, arrayMapValues[i])) {
                                                            updateDayToArray(workDaysForm, arrayMapValues[i])
                                                        } else {
                                                            workDaysForm.push(arrayMapValues[i])
                                                        }
                                                        setFieldValue("daysworks", workDaysForm)
                                                    }
                                                }} weekdays={[{ id: "1", day: "Lunes" }, { id: "2", day: "Martes" }, { id: "3", day: "Miercoles" }, { id: "4", day: "Jueves" }, { id: "5", day: "Viernes" }, { id: "6", day: "Sabado" }, { id: "7", day: "Domingo" }]} className={`field ${errors.price && touched.price ? "is-invalid" : ""}`} placeholder="Cosas que vendas,dedicacion,etc" />
                                                <ErrorMessage name="daysworks" component="div" className="form-group-error" />
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
                            <div className="button-toolbar form-button-toolbar" style={{ float: "right" }}>
                                <button
                                    className="button button-primary flex-center"
                                    disabled={isSubmitting}
                                    type="submit"
                                >
                                    {values.id > 0 ? "Editar" : "Crear"}
                                    {isSubmitting && <Spinner type="Circles" />}
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