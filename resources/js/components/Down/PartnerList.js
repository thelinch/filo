import React from "react"
import { Card, CardMedia, CardActionArea, CardContent, Grid, Typography } from "@material-ui/core"
import PropTypes from "prop-types";
import Skeleton from '@material-ui/lab/Skeleton';
import Box from '@material-ui/core/Box';
import LocationOnIcon from '@material-ui/icons/LocationOn';
import PhoneIcon from '@material-ui/icons/Phone';
import Chip from '@material-ui/core/Chip';

const PartnerList = ({ partners, handleClick }) => {

    const skeletonParnertList = [1, 2, 3, 4, 5, 6].map((e) => (
        <Grid item xs={12} md={4}>
            <Box width="100%" height={150}>
                <Skeleton variant="rect" height="100%" />
            </Box>
        </Grid>


    ));
    const partnersMap = partners.map((partner) => (
        <Grid item xs={12} md={4} >
            <Card className="partner" key={partner.id} onClick={handleClick(partner)}>
                <CardActionArea>
                    <CardMedia >
                        <Chip label={partner.category.name} className="category" />
                        <img src={partner.photo} />
                    </CardMedia>

                </CardActionArea>
                <CardContent className="partner-content">
                    <h6 className="partner-title ">
                        {partner.name}
                    </h6>
                    <div className="partner-description">
                        {partner.description}
                        {
                            !partner.isAvailableForAttend && (
                                <p className="text-center">
                                    <strong>
                                        {partner.textAlternativeForAttend()}
                                    </strong>
                                </p>)
                        }
                    </div>
                    <Box display="flex" justifyContent="space-around" >
                        <Box display="flex" alignItems="center">
                            <PhoneIcon /> {partner.phone}
                        </Box>
                        <Box display="flex" alignItems="center">
                            <LocationOnIcon /> {partner.address}
                        </Box>
                    </Box>
                </CardContent>
            </Card>
        </Grid >

    ))
    return (
        <Grid container spacing={2}>{
            partners.length == 0 ? skeletonParnertList : partnersMap}
        </Grid>
    );
}

PartnerList.propTypes = {
    partners: PropTypes.arrayOf(PropTypes.shape({
        name: PropTypes.string,
        photo: PropTypes.string,
        address: PropTypes.string
    }).isRequired).isRequired,
    handleClick: PropTypes.func
}
PartnerList.defaultProps = {
    partners: []
}

export default PartnerList;
