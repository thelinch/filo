import React from "react"
import Transaction from "../../Transaction/Transaction";
import PropTypes from "prop-types";
import Skeleton from '@material-ui/lab/Skeleton';
import Box from '@material-ui/core/Box';
import Grid from "@material-ui/core/Grid";

const TransactionList = ({ transactions, isLoading }) => {
    const notTransaction = (<div width="100%" className="not-items" >
        <strong className="message">No existe registros</strong>
    </div>);
    const skeletonTransactionList = [1, 2, 3, 4, 5, 6].map((e) => (
        <Grid item xs={12} md={4} key={e}>
            <Box width="100%" height={150}>
                <Skeleton variant="rect" height="100%" />
            </Box>
        </Grid>


    ));
    const transactionsMap = transactions.map((transaction) => (
        <Grid item xs={12} md={4} >
            <Transaction transaction={transaction} />
        </Grid >

    ))
    return (
        <Grid container spacing={2}>{
            isLoading ? skeletonTransactionList : transactions.length == 0 ? notTransaction : transactionsMap}
        </Grid>
    );
}



export default TransactionList;
