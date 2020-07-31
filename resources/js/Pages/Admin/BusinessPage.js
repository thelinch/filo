import React from "react";
import { Grid, Paper } from "@material-ui/core";
import BusinessForm from "../../components/Form/BusinessForm";


const BusinessPage = (props) => {

    return (<Grid container>
        <Grid item xs={12}>
            <Paper variant="outlined" square >
                <BusinessForm />
            </Paper>
        </Grid>
    </Grid>);


}

export default BusinessPage;