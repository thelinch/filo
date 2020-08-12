import React, { useEffect, useState, useContext } from "react";
import { Grid, Paper } from "@material-ui/core";
import BusinessForm from "../../components/Form/BusinessForm";
import { AuthUserContext } from "../../Contexts/AuthUserContext";

const BusinessPage = (props) => {
    const { userIsAdmin } = useContext(AuthUserContext)
    return (<Grid container>
        {
            !userIsAdmin && <Grid item xs={12}>
                <div className="notification default">
                    <p>
                        Registra tu negocio y vende por el metodo de delivery
                </p>
                </div>
            </Grid>

        }
        <Grid item xs={12}>
            <Paper variant="outlined" square style={{ padding: "1.5rem" }} >
                <BusinessForm />
            </Paper>
        </Grid>
    </Grid>);


}

export default BusinessPage;