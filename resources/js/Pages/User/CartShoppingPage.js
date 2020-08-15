import React, { useContext, useState } from "react"
import { Grid, Divider, Typography } from "@material-ui/core"
import ShoppingCart from "../../components/Shopping cart/ShoppingCart"
import { Link } from "@reach/router";
import { CartContext } from "../../Contexts/CartContext";
import { generateUuid, transformDomainToJson } from "../../Util/Util";
import { TransactionService } from "../../Services/TransactionService";
import ShoppingCartForm from "../../components/Form/ShoppingCartForm";
import { messageSuccessTransaction } from "../../Util/Swal";

const CartShoppingPage = (props) => {
    const { items, updateCart } = useContext(CartContext)
    const amountDelivery = items.length > 0 ? items[0].partner.amountdelivery || items[0].partner._amountdelivery : 0
    const handleBuy = async (values) => {
        let partnerId = items[0].partner._id;
        let itemsMap = items.map((item) => (transformDomainToJson(item)))
        let buyBody = { items: itemsMap, id: generateUuid(), partnerId, ...values }
        let code = (await TransactionService.save(buyBody)).data;
        updateCart([]);
        messageSuccessTransaction(code);
    }
    return <Grid container>
        <div className="text-center" style={{ width: "100%" }}>
            <Typography variant="h4" className="text-center">
                Detalles del Pedido
        </Typography>
        </div>
        <Grid item xs={12}>
            <div className="cart">
                <ShoppingCart />
            </div>

        </Grid>
        <Grid item xs={12}>
            {
                props.isAuthenticated ?
                    items.length > 0 &&
                    <React.Fragment>
                        <Divider />
                        <p>
                            {
                                amountDelivery == 0 ?
                                    <div className="notification success">El delivery es gratis!! </div> : <div className="notification default">Costo por delivery S./ {amountDelivery}</div>

                            }
                        </p>
                        <ShoppingCartForm onSubmit={handleBuy} />
                    </React.Fragment>
                    : <button className="button button-secondary" style={{ float: "right" }}>
                        <Link to="/credential">
                            Iniciar sesion
                        </Link>
                    </button>
            }
        </Grid>

    </Grid >

}
export default CartShoppingPage;