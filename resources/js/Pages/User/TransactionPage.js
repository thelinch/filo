import React, { useState, useEffect } from "react"
import { TransactionService } from "../../Services/TransactionService"
import qs from "qs"
import TransactionDomain from "../../Domain/TransactionDomain"
import { Grid } from "@material-ui/core"
import TransactionList from "../../components/Down/Transaction/TransactionList"
import { messageSuccess } from "../../Util/Swal"
const TransactionPage = (props) => {
    const itemSearch = qs.parse(props.location.search, { ignoreQueryPrefix: true })?.item
    const [transactions, setTransactions] = useState([])
    const [isLoading, setIsLoading] = useState(true)
    const handleCancelled = (transaction) => async () => {
        await TransactionService.cancelled(transaction)
        let index = transactions.findIndex((transactionP) => transactionP.id == transaction.id);
        transactions[index].state = "Cancelado"
        setTransactions(curr => [...transactions])
        messageSuccess();
    }
    const handlelOnMyWay = (transaction) => async () => {
        await TransactionService.onMyWay(transaction)

        let index = transactions.findIndex((transactionP) => transactionP.id == transaction.id);
        transactions[index].state = "En camino"
        setTransactions(curr => [...transactions])
        messageSuccess()
    }
    const handleAttended = (transaction) => async () => {
        await TransactionService.attended(transaction)
        let index = transactions.findIndex((transactionP) => transactionP.id == transaction.id);
        transactions[index].state = "Atendido"
        setTransactions(curr => [...transactions])
        messageSuccess()
    }
    useEffect(() => {
        async function fetchTransactionByUser() {
            let transactionsData = (await TransactionService.listFindUser()).data
            let transactionsMap = transactionsData.map((transaction) => {
                let transactionDomain = new TransactionDomain(transaction.id, transaction.items, transaction.total, transaction.state, transaction.code, transaction.phone, transaction.direction, transaction.amountpayment, transaction.created_at)
                transactionDomain.business = transaction.business
                transactionDomain.user = transaction.user
                return transactionDomain;
            })
            setIsLoading(false)
            setTransactions(transactionsMap)
        }
        async function fetchTransactionByPartner() {
            let transactionsData = (await TransactionService.listFindPartner()).data
            let transactionsMap = transactionsData.map((transaction) => {
                let transactionDomain = new TransactionDomain(transaction.id, transaction.items, transaction.total, transaction.state, transaction.code, transaction.phone, transaction.direction, transaction.amountpayment, transaction.created_at)
                transactionDomain.business = transaction.business
                transactionDomain.user = transaction.user
                return transactionDomain;
            })
            setIsLoading(false)
            setTransactions(transactionsMap)
        }
        if (props.location.pathname == "/sales") {
            fetchTransactionByPartner()
        } else {
            fetchTransactionByUser();
        }
    }, [])
    return <Grid container>
        <TransactionList transactions={transactions} transactionSelect={itemSearch} onCancelled={handleCancelled} onAttended={handleAttended} onOnMyWay={handlelOnMyWay} path={props.location.pathname} isLoading={isLoading} />
    </Grid>
}

export default TransactionPage;