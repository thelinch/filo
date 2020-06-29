

import React from "react"
import { Router } from "@reach/router"
import InitPage from "./InitPage"
import ProductPage from "./ProductPage"

class LayoutAdmin extends React.Component {
    constructor(props) {
        super(props)
    }

    render() {
        return (
            <React.Fragment>
                <main className="main">
                    <Router>
                        <InitPage path="/" />
                        <ProductPage path="/products" />
                    </Router>
                </main>
            </React.Fragment>

        )
    }
}

export default LayoutAdmin;