import React from "react"
import { Grid, Box } from "@material-ui/core";
import PhoneIcon from '@material-ui/icons/Phone';

const PartnerOne = ({ partner }) => {

    return (
        <Grid container spacing={1} className="partner-one">

            <Grid item xs={12} md={2}>
                <img src={partner.photo} className="img" />
            </Grid>
            <Grid item xs={12} md={8}>
                <div className="content">
                    <h6 className="title">{partner.name}</h6>
                    <p className="description">{partner.description}</p>
                </div>
            </Grid>
            <Grid item xs={12} md={2}>
                <Box display="flex" alignItems="center" className="phone">
                    <PhoneIcon /> {partner.phone}
                </Box>
            </Grid>
        </Grid>

    );


}

export default PartnerOne;



