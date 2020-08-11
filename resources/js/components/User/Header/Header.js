import { AppBar, Toolbar, Typography, MenuItem, Menu, Button } from "@material-ui/core"

import React from "react";
import InputBase from '@material-ui/core/InputBase';
import { fade, makeStyles } from '@material-ui/core/styles';
import SearchIcon from '@material-ui/icons/Search';
import IconButton from '@material-ui/core/IconButton';
import Search from "../../Search/Search";
import ShoppingCartIconComponent from '../../Shopping cart/ShoppingCartIcon';
import PropTypes from "prop-types"
import DehazeIcon from '@material-ui/icons/Dehaze';
import { Link } from "@reach/router";
import Hidden from '@material-ui/core/Hidden';
import cookie from 'react-cookies';
import { connect } from 'react-redux';
import List from '@material-ui/core/List';
import ListItem from "@material-ui/core/ListItem";
import Drawer from '@material-ui/core/Drawer';
import { getUser, currentUserIsAdmin } from "../../../Util/Util";
import { CredentialService } from "../../../Services/CredentialService";
import { logout } from "../../../redux/actions/authActions"
import {navigate} from "@reach/router"
const useStyles = makeStyles((theme) => ({
    root: {
        flexGrow: 1,
    },
    menuButton: {
        marginRight: theme.spacing(2),
    },
    title: {
        flexGrow: 1,
        display: 'none',
        [theme.breakpoints.up('sm')]: {
            display: 'block',
        },
    },
    search: {
        position: 'relative',
        borderRadius: theme.shape.borderRadius,
        backgroundColor: fade(theme.palette.common.white, 0.15),
        '&:hover': {
            backgroundColor: fade(theme.palette.common.white, 0.25),
        },
        marginLeft: 0,
        width: '80%',
        [theme.breakpoints.up('sm')]: {
            marginLeft: theme.spacing(1),
            width: '80%',
        },
    },
    searchIcon: {
        padding: theme.spacing(0, 2),
        height: '100%',
        position: 'absolute',
        pointerEvents: 'none',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
    },
    inputRoot: {
        color: 'inherit',
    },
    inputInput: {
        padding: theme.spacing(1, 1, 1, 0),
        // vertical padding + font size from searchIcon
        paddingLeft: `calc(1em + ${theme.spacing(4)}px)`,
        transition: theme.transitions.create('width'),
        width: '100%',
        /*    [theme.breakpoints.up('sm')]: {
               width: '12ch',
               '&:focus': {
                   width: '20ch',
               },
           }, */
    },
}));
const Header = ({ isAuthenticated, dispatch,isRoleAdmin }, ...props) => {
    console.log(isAuthenticated)
    const classes = useStyles();
    const [collapse, setCollapse] = React.useState(null);
    const [openDrawer, setOpenDrawer] = React.useState(false)
    const handleCloseSession = () => {
        CredentialService.logout();
        cookie.remove("token");
        localStorage.removeItem("user")
        dispatch(logout());
        navigate("/credential")

    }
    const toggleDrawer = () => {
        setOpenDrawer(!openDrawer)
    }
    const toggle = (value) => {
        setCollapse(value)
    }
    return (
        <React.Fragment>
            <AppBar position="static">
                <Toolbar className="topbar__wrapper">
                    <div className="topbar__left">
                        <Hidden lgUp >
                            <DehazeIcon className="topbar__button-icon" onClick={toggleDrawer} />
                            <Drawer open={openDrawer} className="wrapper" onClose={toggleDrawer} >
                                <List className="wrapper topbar__menu-profile-user">

                                    {
                                        isAuthenticated ? (
                                            <React.Fragment>
                                                <ListItem>
                                                    <div className="topbar__menu-profile-user text-center">
                                                        <Typography variant="h4" weight="medium" className="topbar__user-name">
                                                            {getUser()?.name}</Typography>
                                                    </div>
                                                </ListItem>
                                                <Link to="/" className="topbar__link">
                                                    <ListItem >
                                                        <Typography
                                                            className="topbar__link"
                                                            color="primary"
                                                        >
                                                            Inicio
                                                </Typography>
                                                    </ListItem>
                                                </Link>
                                                <Link to="/perfil" className="topbar__link">
                                                    <ListItem >
                                                        <Typography
                                                            className="topbar__link"
                                                            color="primary"
                                                        >
                                                            Perfil
                                                </Typography>
                                                    </ListItem>
                                                </Link>
                                                <Link to="/business" className="topbar__link">
                                                    <ListItem >
                                                        <Typography
                                                            className="topbar__link"
                                                            color="primary"
                                                        >
                                                            Negocio
                                                </Typography>
                                                    </ListItem>
                                                </Link>
                                            <Link to="/products" className="topbar__link">
                                                    {
                                                        isRoleAdmin && 
                                                        <React.Fragment>

                                                        <Link to="/products" className="topbar__link">
                                                            <ListItem >
                                                            <Typography
                                                                color="primary"

                                                            >
                                                                Productos
                                                                </Typography>
                                                        </ListItem>

                                                        </Link>
                                                       <Link to="/sales" >
                                                        <ListItem >
                                                            <Typography
                                                                className="topbar__link"
                                                                color="primary"

                                                            >
                                                                Ventas
                                                                </Typography>
                                                        </ListItem>
                                                       </Link>
                                                        </React.Fragment>

                                                    }
                                                </Link> 
                                                <Link to="/buys" className="topbar__link">
                                                    <ListItem >
                                                        <Typography
                                                            className="topbar__link"
                                                            color="primary"
                                                        >
                                                            Compras
                                                </Typography>
                                                    </ListItem>
                                                </Link>
                                                <ListItem className="flex " style={{ justifyContent: "center" }}>
                                                    <button className="button button-secondary" onClick={handleCloseSession}>
                                                        Cerrar sesion
                                            </button>
                                                </ListItem>
                                            </React.Fragment>

                                        ) : <Link to="/credential" className="topbar__link">
                                                <ListItem >
                                                    <Typography
                                                        className="topbar__link"
                                                        color="primary"

                                                    >
                                                        Iniciar Session
                                                </Typography>
                                                </ListItem>
                                            </Link>
                                    }
                                </List>

                            </Drawer>
                        </Hidden>
                        <div className={classes.search}>
                            <div className={classes.searchIcon}>
                                <SearchIcon />
                            </div>
                            <InputBase
                                placeholder="¿Que desea Buscar?"
                                classes={{
                                    root: classes.inputRoot,
                                    input: classes.inputInput,
                                }}
                                inputProps={{ 'aria-label': 'search' }}
                            />
                        </div>
                    </div>

                    <div className="topbar__right">
                        <ShoppingCartIconComponent/>
                        {
                            isAuthenticated ? ( <Hidden mdDown>
                                <div className="topbar__profile">
                                    <Button
                                        aria-controls="fade-menu" aria-haspopup="true"
                                        style={{ color: "white", borderColor: "white" }}
                                        variant="outlined"
                                        startIcon={<DehazeIcon className="topbar__button-icon" />}
                                        onClick={e => toggle(e.currentTarget)}
                                        className="topbar__button"
                                    >
                                        Mi Cuenta</Button>
                                    <Menu
                                        id="fade-menu"
                                        open={Boolean(collapse)}
                                        anchorEl={collapse}
                                        onClose={() => toggle(null)}
                                        className="topbar__menu-wrap"
                                        classes={{ paper: 'topbar__menu-profile' }}
                                        disableAutoFocusItem
                                    >
                                        <div className="topbar__menu-profile-user text-center">
                                            <Typography variant="h4" weight="medium" className="topbar__user-name">
                                                {getUser()?.name}</Typography>
                                        </div>
                                        <div className="topbar__menu-profile-user">
                                            <MenuItem>
                                                <Link to="/" className="topbar__link">
                                                    <Typography
                                                        className="topbar__link"
                                                        color="primary"
        
                                                    >
                                                        Inicio
        
                                                        </Typography>
                                                </Link>
                                            </MenuItem>
                                            <MenuItem>
                                                <Link to="/perfil" className="topbar__link">
                                                    <Typography
                                                        className="topbar__link"
                                                        color="primary"
        
                                                    >
                                                        Perfil
        
                                                        </Typography>
                                                </Link>
                                            </MenuItem>
                                            <MenuItem>
                                                <Link to="/business" className="topbar__link">
                                                    <Typography
                                                        className="topbar__link"
                                                        color="primary"
        
                                                    >
                                                        Negocio
        
                                                        </Typography>
                                                </Link>
                                            </MenuItem> 
                                            
                                           {
                                                isRoleAdmin &&   
                                                <React.Fragment>

                                                <MenuItem>
                                                <Link to="/products" className="topbar__link">
                                                    <Typography
                                                        className="topbar__link"
                                                        color="primary"
        
                                                    >
                                                        Productos
        
                                                        </Typography>
                                                </Link>
                                            </MenuItem>
                                                <MenuItem>
                                                <Link to="/sales" className="topbar__link">
                                                    <Typography
                                                        className="topbar__link"
                                                        color="primary"
        
                                                    >
                                                        Ventas
        
                                                        </Typography>
                                                </Link>
                                            </MenuItem>
                                                </React.Fragment>
                                            } 
                                      <MenuItem>
                                      <Link to="/buys" className="topbar__link">
                                                    <Typography
                                                        className="topbar__link"
                                                        color="primary"
        
                                                    >
                                                        Compras
        
                                                        </Typography>
                                                </Link>
                                      </MenuItem>

                                            <MenuItem >
                                                <button className="button button-secondary" onClick={handleCloseSession}>
                                                    Cerrar sesion
                                                    </button>
                                            </MenuItem>
                                        </div>
                                    </Menu>
                                </div>
                            </Hidden>):
                            <Hidden mdDown>
                                 <Button
                                        style={{ color: "white", borderColor: "white" }}
                                        variant="outlined"
                                        className="topbar__button"
                                        onClick={()=>{
                                            navigate("/credential")
                                        }}
                                    >
                                  Iniciar Sesion</Button>
                            </Hidden>
                        }
                    </div>

                </Toolbar>
            </AppBar>
            {/*  <Search /> */ }
        </React.Fragment >
    )
}
Header.propTypes = {
    isAuthenticated: PropTypes.bool.isRequired,
    isRoleAdmin:PropTypes.bool.isRequired
}
Header.defaultProps = {
    isAuthenticated: false,
    isRoleAdmin:false
}
export default connect()(Header);