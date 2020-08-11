import React from "react"
import { Paper, Card } from "@material-ui/core"
import TransactionItems from "./TransactionItems"

const Transaction = ({ transaction }) => {

    return <Paper className="transaction">

        <div className="transaction-title">
            <h2 className="title">{transaction.business}</h2>
            <span className="transaction-state" style={{ backgroundColor: transaction.color }}>{transaction.state}</span>
        </div>
        <div className="transaction-items">
            <TransactionItems items={transaction.items} />
        </div>
        <div className="transaction-total">
            <span className="transaction-date">
                {transaction.transformDateToLenguageHuman}
            </span>
            <strong>

                Total S./ {transaction.total}
            </strong>
        </div>
        <div className="transaction-actions">


        </div>
    </Paper >

}
export default Transaction;
