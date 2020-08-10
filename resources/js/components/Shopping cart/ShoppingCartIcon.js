
import React, { useContext } from "react"
import { CartContext } from "../../Contexts/CartContext"
import Badge from '@material-ui/core/Badge';
import { Menu, Divider } from "@material-ui/core";
import ShoppingCartIcon from '@material-ui/icons/ShoppingCart';
import { Link } from "@reach/router";
import ShoppingCart from "./ShoppingCart";
const ShoppingCartIconComponent = (props) => {
    const { items } = useContext(CartContext)
    const [collapse, setCollapse] = React.useState(null);
    const toggle = (value) => {
        setCollapse(value)
    }
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
            classes={{ paper: 'topbar__menu-profile cart icon' }}
            disableAutoFocusItem style={{ padding: ".4rem" }}
        >
            <ShoppingCart />
            {
                items.length > 0 && <Link to="/cart">
                    Ver carrito completo
                            </Link>
            }

        </Menu>
    </React.Fragment>




}
export default ShoppingCartIconComponent;