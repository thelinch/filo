import React, { useContext } from "react";
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import Badge from '@material-ui/core/Badge';
import { CartContext } from "../../Contexts/CartContext";
import { Menu, Divider } from "@material-ui/core";
import ListItemShoppingCart from "./ListItemShoppingCart";
import { Link } from "@reach/router";
const ShoppingCart = (props) => {
    const { items } = useContext(CartContext);
    const [collapse, setCollapse] = React.useState(null);
    const toggle = (value) => {
        setCollapse(value)
    }
    const total = items.reduce((prev, current) => (prev + current.price * current.quantity), 0)

    return <React.Fragment>
        <Badge badgeContent={items.length} color="secondary">
            <ShoppingCartIcon aria-controls="simple-menu" className="topbar__button-icon" aria-haspopup="true" onClick={toggle} />

        </Badge>
        <Menu
            id="fade-menu"
            open={Boolean(collapse)}
            anchorEl={collapse}
            onClose={() => toggle(null)}
            className="topbar__menu-wrap "
            classes={{ paper: 'topbar__menu-profile cart' }}
            disableAutoFocusItem
        >
            <div className="content">
                {
                    items.length == 0 ? <p>No hay elementos</p> :
                        <React.Fragment>

                            <table className="table">
                                <thead className="head">
                                    <tr className="tr tr_first">
                                        <th>Imagen</th>
                                        <th>Denominacion</th>
                                        <th>Cant.</th>
                                        <th>P.U</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {
                                        <ListItemShoppingCart itemsP={items} />
                                    }

                                </tbody>
                            </table>
                            <strong style={{ display: "block", textAlign: "end" }}>
                                Total S./ {total}
                            </strong>
                            <Link to="/">
                                Ver carrito completo
                            </Link>
                        </React.Fragment>

                }

            </div>
        </Menu>
    </React.Fragment>
}

export default ShoppingCart;