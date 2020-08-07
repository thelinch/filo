import React from "react"
import { Router } from "@reach/router"
import InitPage from "./InitPage"
import PartnerPage from "./PartnerPage"
import { SearchProvider } from "../../Contexts/SearchContext";
import Header from "../../components/User/Header/Header";
import { CartProvider } from "../../Contexts/CartContext";
import ProductPage from "../Admin/ProductPage copy";
import BusinessPage from "../Admin/BusinessPage";
import CredentialsPage from "../User/CredentialsPage";
import { connect } from "react-redux"
const Layout = (props) => {
    return (
        <CartProvider>
            <SearchProvider>
                <nav>
                    <Header isAuthenticated={props.isAuthenticated} />
                </nav>
                <div className="main" style={{ minHeight: "100vh", paddingTop: ".5rem", paddingBottom: ".5rem" }}>
                    <Router>
                        <InitPage path="/" />
                        <PartnerPage path="/partner/:partnerId" />
                        <ProductPage path="/products" />
                        <BusinessPage path="/business" />
                        <CredentialsPage path="/credential" />
                    </Router>
                </div>
            </SearchProvider>
        </CartProvider>
    )
}


export default connect(state => ({
    isAuthenticated: state.auth.isAuthenticated
}))(Layout);


