import React, { useState, useEffect, useContext } from "react"
import {
    Formik, Form, Field, ErrorMessage
} from 'formik';

import FileForm from "./Shared/FileForm"
import Grid from "@material-ui/core/Grid";
import Input from "@material-ui/core/Input";
import Spinner from "../Spinner/Spinner";
import WeekCalendar from "../Calendar/WeekCalendar"
import { connect } from 'react-redux';
import { transformDataWeekDayToLinealObject, hasSendFileToServer, removeObjectDayToArray, updateDayToArray, hasContentDayToArray, updateObjetToArray, generateUuid, setUser, getUser, currentUserIsAdmin } from "../../Util/Util";
import Chip from "@material-ui/core/Chip";
import Box from "@material-ui/core/Box";
import SelectField from "./Shared/SelectField";
import { CategoryService } from "../../Services/CategoryService"
import { FileService } from "../../Services/FileService";
import { BusinessService } from "../../Services/BusinessService"
import productUtil from "../../Util/Product/Util";
import * as Yup from "yup";
import { AuthUserContext } from "../../Contexts/AuthUserContext";
const validateSchema = Yup.object().shape({
    name: Yup.string().required("Requerido"),
    email: Yup.string().email("ingrese un email valido").required("requerido"),
    description: Yup.string().required("requerido"),
    category: Yup.object().shape({
        id: Yup.number()
    }).required("requerido"),
    city: Yup.object().shape({
        id: Yup.number()
    }).required("requerido"),
    address: Yup.string().required("requerido"),
    phone: Yup.string().required("requerido"),
    amountdelivery: Yup.number().min(0, "El numero minimo es 0").required("requerido"),
    photo: Yup.array().required("Requerido"),
    workdays: Yup.array().required("Requerido")
})
const BusinessForm = ({ dispatch }) => {
    const { setUserIsAdmin, userIsAdmin, userAuth } = useContext(AuthUserContext)
    const [business, setBusiness] = useState({ id: 0, name: "", description: "", email: "", category: { id: "" }, city: { id: "" }, address: "", phone: userAuth.phone, amountdelivery: "", photo: [], workdays: [], state: 1 })
    const [categories, setCategories] = useState([])
    const [isLoadBusiness, setIsLoadBusiness] = useState(true)
    const [cities, setCities] = useState([{ label: "Yanahuanca", value: 2 }, { label: "Tingo Maria", value: 1 }])

    const onSubmit = async (values) => {
        let url = ""
        let businessSubmit = { ...values };
        if (hasSendFileToServer(values.photo[0])) {
            let formData = new FormData();
            formData.append("files[]", values.photo[0]);
            url = ((await FileService.save(formData, "images")).data)[0].url;
            businessSubmit.photo = url;
        }
        if (values.id == 0) {
            businessSubmit.id = generateUuid();
            businessSubmit.workdays = values.workdays.map(workday => ({ id: generateUuid(), ...workday }))
            await BusinessService.save(businessSubmit)

            setUserIsAdmin(true)
            setBusiness({ ...business, id: businessSubmit.id })
        } else {
            if (url == "") {
                values.photo = business.photo[0].source;
            }
            await BusinessService.update(values);
        }
    }
    const onSelectInterval = async (workdays, valuesSelectinterval, functionUpdate) => {
        let workDaysForm = workdays;
        let arrayMapValues = transformDataWeekDayToLinealObject(valuesSelectinterval);
        for (let i = 0; i < arrayMapValues.length; i++) {
            if (hasContentDayToArray(workDaysForm, arrayMapValues[i])) {
                updateDayToArray(workDaysForm, arrayMapValues[i])
            } else {
                workDaysForm.push({ id: generateUuid(), ...arrayMapValues[i] })
            }
            if (business.id != 0) {
                await BusinessService.addAndUpdateWorDay(workDaysForm, business.id)
            }
            functionUpdate("workdays", workDaysForm);
        }
    }
    useEffect(() => {
        async function fetchCategoriesApi() {

            let dataCategories = (await CategoryService.getAll()).data
            dataCategories = dataCategories.map(category => ({ value: category.id, label: category.name }))
            setCategories(dataCategories)
        }
        fetchCategoriesApi();
    }, [])
    useEffect(() => {
        async function fetchBusiness() {
            let business = (await BusinessService.get()).data
            setBusiness({ ...business, email: "dwdwd@und.di", photo: [productUtil.transformPhotoSaved(business.photo)] });
            setIsLoadBusiness(false)

        }
        if (!userIsAdmin) {
            setIsLoadBusiness(false)
            return;
        }
        fetchBusiness();
    }, [])
    const handleToggleState = (business, setFieldValue) => () => {
        BusinessService.toogleState(business);
        setFieldValue("state", business.state == 1 ? 0 : 1)

    }
    const handleDeleteHour = (hour, daysworks, functionUpdate) => () => {
        if (daysworks.length == 1) {
            alert("Al  menos debe haber un dia de atencion")
            return;
        }
        if (hour.id) {
            console.log("Mandando al servidor para eliminar")
            BusinessService.deleteWorkDay(hour, business.id);
        }
        functionUpdate("workdays", removeObjectDayToArray(daysworks, hour))
    }
    const onRemoveFile = (file) => {
        console.log("file", file)
    }

    return <Formik initialValues={business} enableReinitialize={true} validationSchema={validateSchema} onSubmit={onSubmit} mapPropsToValues={() => {
        return business;
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
                                        <Field placeholder="Numero de telefono" name="phone" type="text" className={`field ${errors.phone && touched.phone ? "is-invalid" : ""}`} />
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
                                        <Field name="email" type="text" placeholder="correo electronico" className={`field ${errors.email && touched.email ? "is-invalid" : ""}`} />
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
                                        <Field name="address" type="text" placeholder="Direccion" className={`field ${errors.address && touched.address ? "is-invalid" : ""}`} />
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
                                        <Field name="description" type="text" as="textarea" className={`field ${errors.description && touched.description ? "is-invalid" : ""}`} placeholder="Cosas que vendas,dedicacion,etc" />
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
                                        <Field name="category.id" component={SelectField} options={categories} className={`field ${errors.category && touched.category ? "is-invalid" : ""}`} placeholder="Categoria al que pertenece" />
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
                                        <Field name="city.id" component={SelectField} options={cities} className={`field ${errors.city && touched.city ? "is-invalid" : ""}`} placeholder="Categoria al que pertenece" />
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
                                        <Field name="amountdelivery" type="text" className={`field ${errors.amountdelivery && touched.amountdelivery ? "is-invalid" : ""}`} placeholder="Costo adicional por el delivery" />
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
                                            {values.workdays.map(selectday => (
                                                <Chip label={
                                                    <React.Fragment key={selectday.day.id}>
                                                        <span>{selectday.day.name}</span>
                                                        <strong style={{ padding: ".3rem" }}>{selectday.startime}-{selectday.endtime}</strong>
                                                    </React.Fragment>
                                                } style={{ margin: ".5em" }} key={selectday.day.id} onDelete={handleDeleteHour(selectday, values.workdays, setFieldValue)} />
                                            ))}
                                        </Box>
                                    }
                                </Grid>
                                <Grid item xs={12}>
                                    <div className="form-group-horizontal">
                                        <span className="form-group-label">Dias de atencion</span>

                                        <div className="form-group-field">
                                            <div className="form-group-input-wrap">
                                                <Field name="workdays" component={WeekCalendar} onIntervalSelect={(valuesSelectinterval) => {
                                                    console.log("hhhhhh")
                                                    onSelectInterval(values.workdays, valuesSelectinterval, setFieldValue)
                                                }} weekdays={[{ id: "1", day: "Lunes" }, { id: "2", day: "Martes" }, { id: "3", day: "Miercoles" }, { id: "4", day: "Jueves" }, { id: "5", day: "Viernes" }, { id: "6", day: "Sabado" }, { id: "7", day: "Domingo" }]} className={`field ${errors.workdays && touched.workdays ? "is-invalid" : ""}`} />
                                                <ErrorMessage name="workdays" component="div" className="form-group-error" />
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
                                        <Field name="photo" component={FileForm} onRemoveFileObject={onRemoveFile} messageUser="Foto de tu empresa" filesParameter={values.photo} directory="images" className={`field ${errors.photo && touched.photo ? "is-invalid" : ""}`} />
                                        <ErrorMessage name="photo" component="div" className="form-group-error" />
                                    </div>
                                </div>
                            </div>
                        </Grid>
                        <Grid item xs={12}>
                            <div className="button-toolbar form-button-toolbar" style={{ float: "right" }}>
                                {

                                    values.id != 0 && <button type="button" onClick={handleToggleState(values, setFieldValue)} className="button button-secondary">
                                        {
                                            values.state == 1 ? "Suspender atencion" : "Volver a abrir"
                                        }
                                    </button>
                                }
                                <button
                                    className="button button-primary flex  aling-center align-space-beetwen"
                                    disabled={isSubmitting || isLoadBusiness}
                                    type="submit"
                                >
                                    {isLoadBusiness ? <Spinner className="spinner primary" type="Circles" height="40px" width="40px" /> : values.id == 0 ? "Crear" : "editar"}
                                    {isSubmitting && <Spinner className="spinner primary" type="Circles" height="40px" width="40px" />}
                                </button>
                            </div>
                        </Grid>
                    </Grid>
                </Form>
            )
        }
    </Formik>

}


export default connect()(BusinessForm);