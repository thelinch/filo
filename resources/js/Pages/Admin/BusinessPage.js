import React, { useEffect, useState } from "react";
import { Grid, Paper } from "@material-ui/core";
import BusinessForm from "../../components/Form/BusinessForm";
import { BusinessService } from "../../Services/BusinessService";


const BusinessPage = (props) => {
    return (<Grid container>
        {
            !props.isRoleAdmin && <Grid item xs={12}>
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