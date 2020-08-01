import React, { useEffect, useState } from "react";
import { Grid, Paper } from "@material-ui/core";
import BusinessForm from "../../components/Form/BusinessForm";
import { BusinessService } from "../../Services/BusinessService";


const BusinessPage = (props) => {

    const [business, setBusiness] = useState(null)
    useEffect(() => {
        async function fetchBusiness() {
            let business = (await BusinessService.get()).data
            setBusiness(business);
        }
        fetchBusiness();
    }, [])

    return (<Grid container>
        <Grid item xs={12}>
            <Paper variant="outlined" square style={{ padding: "1.5rem" }} >
                <BusinessForm BusinessSelect={business} />
            </Paper>
        </Grid>
    </Grid>);


}

export default BusinessPage;