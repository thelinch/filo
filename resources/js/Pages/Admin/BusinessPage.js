import React from "react";
import { Grid } from "@material-ui/core";
import BusinessForm from "../../components/Form/BusinessForm";


const BusinessPage = (props) => {

    return (<Grid container>
        <Grid item xs={12}>
            <BusinessForm />

        </Grid>
    </Grid>);


}

export default BusinessPage;