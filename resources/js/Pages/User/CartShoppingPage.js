import React, { useContext, useState } from "react"
import { Grid } from "@material-ui/core"
import ShoppingCart from "../../components/Shopping cart/ShoppingCart"
import { Link } from "@reach/router";
import { CartContext } from "../../Contexts/CartContext";
import { generateUuid, transformDomainToJson } from "../../Util/Util";
import { TransactionService } from "../../Services/TransactionService";
import Spinner from "../../components/Spinner/Spinner";

const CartShoppingPage = (props) => {
    const { items, updateCart } = useContext(CartContext)
    const [isLoading, setIsLoading] = useState(false)
    const handleBuy = async () => {
        let partnerId = items[0].partner._id;
        let itemsMap = items.map((item) => (transformDomainToJson(item)))
        setIsLoading(true)
        let buyBody = { items: itemsMap, id: generateUuid(), partnerId }
        await TransactionService.save(buyBody);
        updateCart([]);
        setIsLoading(false)
    }
    return <Grid container>
        <Grid item xs={12}>
            <div className="cart">
                <ShoppingCart />
            </div>
        </Grid>
        <Grid item xs={12}>
            {
                props.isAuthenticated ?
                    items.length > 0 && < button onClick={handleBuy} disabled={isLoading} className="button button-primary" style={{ float: "right" }}>
                        Comprar !! {
                            isLoading && <Spinner />
                        }
                    </button> : <button className="button button-secondary" style={{ float: "right" }}>
                        <Link to="/credential">
                            Iniciar sesion
                        </Link>
                    </button>
            }
        </Grid>

    </Grid >

}
export default CartShoppingPage;