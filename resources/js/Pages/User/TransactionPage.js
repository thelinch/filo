import React, { useState, useEffect } from "react"
import { TransactionService } from "../../Services/TransactionService"
import Transaction from "../../components/Transaction/Transaction"
import TransactionDomain from "../../Domain/TransactionDomain"
import { Grid } from "@material-ui/core"
import TransactionList from "../../components/Down/Transaction/TransactionList"
const TransactionPage = (props) => {
    const [transactions, setTransactions] = useState([])
    const [isLoading, setIsLoading] = useState(true)
    useEffect(() => {
        async function fetchTransactionByUser() {
            let transactionsData = (await TransactionService.listFindUser()).data
            let transactionsMap = transactionsData.map((transaction) => {
                let transactionDomain = new TransactionDomain(transaction.id, transaction.items, transaction.total, transaction.state, transaction.code, transaction.phone, transaction.direction, transaction.amountpayment, transaction.created_at)
                transactionDomain.business = transaction.business
                return transactionDomain;
            })
            setIsLoading(false)
            setTransactions(transactionsMap)
        }
        fetchTransactionByUser();
    }, [])
    return <Grid container>
        <TransactionList transactions={transactions} isLoading={isLoading} />
    </Grid>
}

export default TransactionPage;