import React from "react"
import Card from "@material-ui/core/Card"
import Paper from "@material-ui/core/Paper"
import TransactionItems from "./TransactionItems"
import PropTypes from "prop-types";
import ReactTooltip from 'react-tooltip';
const Transaction = ({ transaction, path, onCancelled, onOnMyWay, onAttended, transactionSelect }) => {
    return <Paper className={"transaction ".concat(transactionSelect && (transactionSelect == transaction.id || transactionSelect == transaction.code) ? "select-item" : "")}>
        <div className="transaction-title">
            {
                <h2 className="title">{

                    path == "/sales" ?
                        <span data-tip={transaction.user.phone} data-for="main">{transaction.user.name + `[s./${transaction.amountpayment}]`}</span>
                        : <span data-tip={transaction.business.phone} data-for="main">{transaction.business.name}</span>
                }</h2>
            }
            <span className="transaction-state" style={{ backgroundColor: transaction.color }}>{transaction.state}</span>
            <ReactTooltip id="main" type="warning" />
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
            {
                transaction.canBeRemove && <button className="button-action  cancelled" onClick={onCancelled(transaction)}>
                    Cancelar
                </button>
            }
            {
                transaction.canBeOnMyWay && path == "/sales" && <button className="button-action  onMyWay" onClick={onOnMyWay(transaction)}>
                    En camino
                </button>
            }
            {
                transaction.canBeAttend && path == "/sales" && <button className="button-action  attended" onClick={onAttended(transaction)}>
                    Atender
                </button>
            }

        </div>
    </Paper >

}
Transaction.propTypes = {
    transaction: PropTypes.object.isRequired,
    path: PropTypes.string.isRequired,
    onCancelled: PropTypes.func.isRequired,
    onOnMyWay: PropTypes.func.isRequired,
    onAttended: PropTypes.func.isRequired
}
export default Transaction;
